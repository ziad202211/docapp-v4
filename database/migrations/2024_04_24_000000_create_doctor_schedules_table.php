<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('day');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_schedules');
    }
} 