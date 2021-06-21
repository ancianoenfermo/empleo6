<?php

namespace App\Http\Controllers;

use App\Models\Autonomia;
use App\Models\Job;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Exception;
use PhpParser\Node\Stmt\Break_;

class HomeController extends Controller
{
    private $autonomias;
    private $jobs;

    public function inicio($autonomiaUrl = null, $provinciaUrl = null, $localidadUrl = null, Request $request)
    {
        $autonomias = $this->todasAutonomias();
        $selectedAutonomia = $autonomiaUrl;
        $selectedProvincia = $provinciaUrl;
        $selectedLocalidad = $localidadUrl;









        # Todas las autonomias
        if (!$autonomiaUrl and !$provinciaUrl and !$localidadUrl) {
            $autonomias = $this->todasAutonomias();
            try {
                $parametro = array_keys($_GET)[0];
            } catch (Exception $e) {
                $parametro = "";
            }

            $jobs = $this->todosJobs($parametro);

            $titleH1 = "Empleos en España: encontradas " . $jobs->total() ." ofertas";
            return view("home", compact('autonomias', 'jobs', 'titleH1','parametro'));
        }


        # Una autonomia
        if (!$provinciaUrl and !$localidadUrl) {
            $autonomias = $this->todasAutonomias();
            try {
                $parametro = array_keys($_GET)[0];
            } catch (Exception $e) {
                $parametro = "";
            }
            $autonomiaSelObj = $this->getAutonomia($autonomiaUrl);
            $provincias = $this->provinciasDeAutonomia($autonomiaSelObj[0]);
            $jobs = $this->jobsFromAutonomia($autonomiaSelObj[0], $parametro);
            $titleH1 = "Empleos en " . $autonomiaSelObj[0]->name .": encontradas " . $jobs->total() ." ofertas";
            return view("home", compact('autonomias', 'provincias', 'jobs', 'selectedAutonomia','titleH1','parametro'));
        }

        # Una Provincia
        if (!$request->localidad) {
            $autonomias = $this->todasAutonomias();
            try {
                $parametro = array_keys($_GET)[0];
            } catch (Exception $e) {
                $parametro = "";
            }

            $autonomiaSelObj = $this->getAutonomia($autonomiaUrl);
            $provincias = $this->provinciasDeAutonomia($autonomiaSelObj[0]);
            $provinciaSelObj = $this->getProvincia($provinciaUrl);
            $localidades = $this->localidadesDeProvincia($provinciaSelObj[0]);
            $jobs = $this->jobsFromProvincia($provinciaSelObj[0], $parametro);
            $titleH1 = "Empleos en " . $provinciaSelObj[0]->name .": encontradas " . $jobs->total() ." ofertas";
            return view("home", compact('autonomias', 'provincias', 'localidades', 'jobs', 'selectedAutonomia', 'selectedProvincia','titleH1','parametro'));
        }

        # Una Localidad
        $autonomias = $this->todasAutonomias();
        try {
            $parametro = array_keys($_GET)[0];
        } catch (Exception $e) {
            $parametro = "";
        }
        $autonomiaSelObj = $this->getAutonomia($autonomiaUrl);
        $provincias = $this->provinciasDeAutonomia($autonomiaSelObj[0]);
        $provinciaSelObj = $this->getProvincia($provinciaUrl);
        $localidades = $this->localidadesDeProvincia($provinciaSelObj[0]);
        $localidadSelObj = $this->getLocalidad($localidadUrl);
        $jobs = $this->jobsFromLocalidad($localidadSelObj[0], $parametro);
        $titleH1 = "Empleos en " . $localidadSelObj[0]->name .": encontradas " . $jobs->total() ." ofertas";
        return view("home", compact('autonomias', 'provincias','localidades', 'jobs', 'selectedAutonomia','selectedProvincia','selectedLocalidad','titleH1','parametro'));

    }

    private function todasAutonomias()
    {
        if (Cache::has('todasAutonomias')) {
            $autonomias = Cache::get('todasAutonomias');
        } else {
            $autonomias = Autonomia::orderBy('name')->get();
            Cache::put('todasAutonomias', $autonomias);
        }
        return $autonomias;
    }

    private function getAutonomia($autonomiaUrl)
    {
        $key = 'Autonomia' . $autonomiaUrl;
        if (Cache::has($key)) {
            $autonomia = Cache::get($key);
        } else {
            $autonomia = Autonomia::first()->slug($autonomiaUrl)->get();
            Cache::put($key, $autonomia);
        }
        return $autonomia;
    }
    private function getProvincia($provinciaUrl)
    {
        $key = 'Provincia' . $provinciaUrl;
        if (Cache::has($key)) {
            $provincia = Cache::get($key);
        } else {
            $provincia = Province::first()->slug($provinciaUrl)->get();
            Cache::put($key, $provincia);
        }
        return $provincia;
    }
    private function getLocalidad($localidadUrl)
    {
        $key = 'Localidad' . $localidadUrl;
        if (Cache::has($key)) {
            $localidad = Cache::get($key);
        } else {
            $localidad = Region::first()->slug($localidadUrl)->get();
            Cache::put($key, $localidad);
        }
        return $localidad;
    }




    private function provinciasDeAutonomia($autonomiaObj)
    {
        $key = 'provinciasDe' . $autonomiaObj->slug;
        if (Cache::has($key)) {
            $provincias = Cache::get($key);
        } else {
            $provincias = $autonomiaObj->provinces()->orderBy('name')->get();
            Cache::put($key, $provincias);
        }
        return $provincias;
    }

    private function localidadesDeProvincia($provinciaObj)
    {
        $key = 'localidadesDe' . $provinciaObj->slug;
        if (Cache::has($key)) {
            $localidades = Cache::get($key);
        } else {
            $localidades = $provinciaObj->regions()->orderBy('name')->get();
            Cache::put($key, $localidades);
        }
        return $localidades;
    }




    private function todosJobs($parametro)
    {

        if (request()->page) {
            $key = 'todosJobs' . $parametro. request()->page;
        } else {
            $key = "todosJobs" . $parametro;
        }
        if (Cache::has("$key")) {
            $jobs = Cache::get($key);
        } else {
            if ($parametro) {
                switch ($parametro) {
                    case 'discapacidad':
                        $jobs = Job::discapacidad("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'teletrabajo':
                        $jobs = Job::teletrabajo("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'practicas':
                        $jobs = Job::practicas("1")->orderBy('orden')->paginate(15);
                        break;
                    default:
                        $jobs = Job::orderBy('orden')->paginate(15);
                }
            } else {
                $jobs = Job::orderBy('orden')->paginate(15);
            }

        Cache::put($key, $jobs);
        }
        return $jobs;
    }

    private function jobsFromAutonomia($autonomia, $parametro)
    {
        if (request()->page) {
            $key = 'JobsAutonomia' . $autonomia->slug .$parametro . request()->page;
        } else {
            $key = "JobsAutonomia" . $autonomia->slug . $parametro;
        }
        if (Cache::has($key)) {
            $jobs = Cache::get($key);
        } else {
            if ($parametro) {
                switch ($parametro) {
                    case 'discapacidad':
                        $jobs = $autonomia->jobs()->discapacidad("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'teletrabajo':
                        $jobs = $autonomia->jobs()->teletrabajo("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'practicas':
                        $jobs = $autonomia->jobs()->practicas("1")->orderBy('orden')->paginate(15);
                        break;

                }
            } else {
                $jobs = $autonomia->jobs()->orderBy('orden')->paginate(15);
            }
            Cache::put($key, $jobs);
        }
        return $jobs;
    }

    private function jobsFromProvincia($provincia, $parametro)
    {
        if (request()->page) {
            $key = 'JobsProvincia' . $provincia->slug . $parametro . request()->page;
        } else {
            $key = "JobsProvincia" . $provincia->slug . $parametro;
        }

        if (Cache::has($key)) {
            $jobs = Cache::get($key);
        } else {
            if ($parametro) {
                switch ($parametro) {
                    case 'discapacidad':
                        $jobs = $provincia->jobs()->discapacidad("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'teletrabajo':
                        $jobs = $provincia->jobs()->teletrabajo("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'practicas':
                        $jobs = $provincia->jobs()->practicas("1")->orderBy('orden')->paginate(15);
                        break;
                }
            } else {
                $jobs = $provincia->jobs()->orderBy('orden')->paginate(15);
            }
            Cache::put($key, $jobs);
        }
        return $jobs;
    }

    private function jobsFromLocalidad($localidad, $parametro)
    {
        if (request()->page) {
            $key = 'JobsLocalidad' . $localidad->slug . $parametro . request()->page;
        } else {
            $key = "JobsLocalida" . $localidad->slug . $parametro;
        }

        if (Cache::has($key)) {
            $jobs = Cache::get($key);
        } else {
            if ($parametro) {
                switch ($parametro) {
                    case 'discapacidad':
                        $jobs = $localidad->jobs()->discapacidad("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'teletrabajo':
                        $jobs = $localidad->jobs()->teletrabajo("1")->orderBy('orden')->paginate(15);
                        break;
                    case 'practicas':
                        $jobs = $localidad->jobs()->practicas("1")->orderBy('orden')->paginate(15);
                        break;
                }
            } else {
                $jobs = $localidad->jobs()->orderBy('orden')->paginate(15);
            }

            Cache::put($key, $jobs);
        }
        return $jobs;
    }
}
/*
$autonomias = $this->autonomias;
        $jobs = $this->jobs;
        return view("home", compact('autonomias', 'jobs'));

        # Toda españa
        if (!$autonomia and !$provincia and !$localidad) {
            if (request()->page) {
                $key = "todosJobs".request()->page;
            } else {
                $key = "todosJobs";
            }
            $jobs = cache()->remember($key, 60*60, function () {
                return Job::paginate(15);
            });

            return view("home", compact("autonomias", "jobs"));
        }

        # Autonomia
        if (!$provincia and !$localidad) {
            dd($autonomia);
            $selectAutonomia = cache()->remember($autonomia, 60*60, function () {
                return  Autonomia::slug($this->autonomia)->first();;
            });
            dd($this->$autonomia);
            $selectedAutonomia = $selectAutonomia->name;
            $jobs = $selectAutonomia->jobs()->paginate(15);
            $provincias = $selectAutonomia->provinces();
            return view("home", compact("autonomias","provincias", "jobs","selectedAutonomia"));
        }

        # Provincia
        if (!$localidad) {
            $jobs = Job::all();
            return view("home", compact("autonomia", "jobs"));
        }
        # Localidad

        $jobs = Job::all();
        return view("home", compact("autonomia", "jobs"));
*/
