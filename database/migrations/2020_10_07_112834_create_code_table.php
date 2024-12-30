<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2020_10_07_112834_create_code_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('code', function (Blueprint $table) {
             $table->id();
             $table->string('description')->nullable();
             $table->string('email')->nullable();
             $table->string('type')->nullable();
             $table->string('code')->nullable();
             $table->string('user_password')->nullable();
             $table->timestamp('code_datetime')->nullable();
             $table->integer('user_id')->nullable();
             $table->string('code_ip')->nullable();
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
        Schema::dropIfExists('code');
    }
}
