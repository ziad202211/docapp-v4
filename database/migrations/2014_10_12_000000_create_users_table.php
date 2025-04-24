<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone')->nullable()->change();
        $table->string('email')->unique();
        $table->enum('role', ['doctor', 'patient']);
        $table->enum('gender', ['Male', 'Female']);
        $table->string('password');
        $table->timestamps();
    });
    
}
// $table->string('role')->default('patient'); // 'doctor' or 'patient'


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
