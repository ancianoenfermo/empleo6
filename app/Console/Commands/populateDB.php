<?php

namespace App\Console\Commands;

use App\Models\Autonomia;
use Illuminate\Console\Command;
use App\Models\Job;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;


class populateDB extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:empleos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Llena de empleos la Base de Datos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $logoFunte = array();
        // Comprueba si hay un nuevo fichero de empleos
        if(!file_exists(public_path("collection.json"))) {
            return 0;
        }
        // Activa el modo mantenimiento
        $inicio = now();
        Artisan::call('down',['--redirect'=>null,'--retry'=>null,'--secret'=>null,'--status'=>'503']);
        //borra la Cache
        Cache::flush();
        // Lee el json de empleos
        $path = public_path() . "/collection.json";
        $json = File::get($path);
        $empleos = json_decode($json, true);



        // Vacia las tablas

        $this->vaciaTablas();



        foreach($empleos as $empleo) {
            $this->trata_empleo($empleo);
        }


        // Desacctiva el modo mantenimiento
        Artisan::call('up');
        $fin = now();
        echo "acabe";
        //File::delete($path);
        return 0;
    }
    public function trata_empleo($empleo) {
        global $logoFuente;

        $autonomia = Autonomia::where('name', $empleo['autonomia'])->first();
        if ($autonomia == null) {
            $newAutonomia = new Autonomia();
            $newAutonomia->name = $empleo['autonomia'];
            $newAutonomia->slug = Str::slug($empleo['autonomia'],'-');
            $autonomia = $newAutonomia;
            $autonomia->save();
        }

        $provincia = Province::where('name', $empleo['provincia'])->first();
        if ($provincia == null) {
            $newProvincia = new Province();
            $newProvincia->name = $empleo['provincia'];
            $newProvincia->slug = Str::slug($empleo['provincia'],'-');
            $newProvincia->autonomia_id = $autonomia->id;
            $provincia = $newProvincia;
            $provincia->save();
        }

        $region = Region::where('name', $empleo['localidad'])->first();
        if ($region == null) {
            $newRegion = new Region;
            $newRegion->name = $empleo['localidad'];
            $newRegion->slug = Str::slug($empleo['localidad'],'-');
            $newRegion->province_id = $provincia->id;
            $region = $newRegion;
            $region->save();
        }


        $newJob = new Job;
        // DEBEN EXISTIR

        $date = Carbon::createFromFormat('d/m/Y', $empleo['datePosted']);
        $dateNow = Carbon::now();
        $cantidadDias = $date->diffInDays($dateNow);
        $llave = strval($cantidadDias);
        if (strlen($llave) == 1) {
            $llave = "0".$llave;
        }
        $llave = $llave.uniqid();
        $newJob->orden = $llave;
        //echo $llave.PHP_EOL;
        $newJob->datePosted = $date;
        $newJob->title = $empleo['title'];

        $newJob->autonomia = $empleo['autonomia'];
        $newJob->autonomia_id = $autonomia->id;

        $newJob->provincia = $empleo['provincia'];
        $newJob->province_id = $provincia->id;

        $newJob->localidad = $empleo['localidad'];
        $newJob->region_id = $region->id;


        if( isset( $empleo['excerpt'] ) ){
            $newJob->excerpt = $empleo['excerpt'];
        }


        $newJob->jobUrl =  $empleo['JobUrl'];
        $newJob->JobFuente = $empleo['JobFuente'];
        if(!isset($empleo['logo'])) {
            echo 'SIN LOGO';
            return;
        }

        // OPCIONALES



        if(!isset($logoFuente[$empleo['JobFuente']])) {
            $logoFuente[$empleo['JobFuente']] = $this->descargarLogo($empleo['logo']);
            //$logoFuente[$empleo['JobFuente']] = $this->descargarLogo("http://www.cantabriafesmcugt.es/wp-content/uploads/2017/07/descarga.png");
            //echo $logoFuente[$empleo['JobFuente']].PHP_EOL;
        }

        $newJob->logo = $logoFuente[$empleo['JobFuente']];

        /*
        $newJob->logo = $empleo['logo'];
        */
        if( isset( $empleo['contrato'] ) ){
            $newJob->contrato = $empleo['contrato'];;
        }


        if( isset( $empleo['jornada'] ) ){
            $newJob->jornada = $empleo['jornada'];
        }
        if( isset( $empleo['experiencia'] ) ){
            $newJob->experiencia = $empleo['experiencia'];
        }
        if( isset( $empleo['vacantes'] ) ){
            $newJob->vacantes = $empleo['vacantes'];
        }

        if( isset( $empleo['salario'] ) ){
            $newJob->salario = $empleo['salario'];
        }

        if( isset( $empleo['teletrabajo'] ) ){
            $newJob->teletrabajo = $empleo['teletrabajo'];
        }

        if( isset( $empleo['discapacidad'] ) ){
            $newJob->discapacidad = $empleo['discapacidad'];
        }

        if( isset( $empleo['practicas'] ) ){
            $newJob->practicas = $empleo['practicas'];
        }

        if( isset( $empleo['ett'] ) ){
            $newJob->ett = $empleo['ett'];
        }

        $newJob->save();

    }


    public function vaciaTablas() {
        DB::statement("SET foreign_key_checks=0");
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
        DB::table($name)->truncate();
        }
        DB::statement("SET foreign_key_checks=1");
        $pathDirectory =storage_path("app/public/logo_images");
        if (File::exists($pathDirectory)) {
            File::deleteDirectory($pathDirectory);
            File::makeDirectory($pathDirectory);
        } else {
            File::makeDirectory($pathDirectory);
        }
    }

    public function descargarLogo($url) {
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        $filename = Str::uuid().'.'.$extension;
        $logo = Image::make($url);
        $logo->resize(null, 35, function ($constraint) {
            $constraint->aspectRatio();
        });
        $logo->save(storage_path('app/public/logo_images/' . $filename));
        /*
        Image::make($url)->save(storage_path('app/public/logo_images/' . $filename));
        */
        return $filename;
    }


}
