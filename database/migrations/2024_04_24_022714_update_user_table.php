<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function($table) {
            $table->enum('gender',array('male','female','other'))->default('male');
            $table->enum('status',array('active','pending','locked','inactive','deleted'))->default('active');
            $table->enum('is_admin',array('yes','no'))->default('no');
            $table->enum('is_root',array('yes','no'))->default('no');
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn([
                'gender',
                'status',
                'is_admin',
                'is_root',
                'phone'
            ]);
        });
    }
};
