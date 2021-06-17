<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string("orden");
            $table->unique('orden');
            $table->dateTime("datePosted");
            $table->string("title");
            $table->string("autonomia",50);
            $table->string('provincia',50);
            $table->string('localidad',50);
            $table->text("excerpt")->nullable();
            $table->text("JobUrl");
            $table->string("JobFuente");
            $table->string("logo")->nullable();
            $table->string("contrato", 150)->nullable();
            $table->string("jornada", 50)->nullable();
            $table->string("experiencia", 50)->nullable();
            $table->string("vacantes", 50)->nullable();
            $table->string("salario", 50)->nullable();
            $table->boolean("ett")->nullable();
            $table->boolean("discapacidad")->nullable();
            $table->boolean("practicas")->nullable();
            $table->boolean("teletrabajo")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
