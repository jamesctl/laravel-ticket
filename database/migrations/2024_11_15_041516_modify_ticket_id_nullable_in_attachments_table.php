<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->bigInteger('ticket_id')->unsigned()->nullable()->change();
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->bigInteger('ticket_id')->unsigned()->nullable(false)->default(0)->change();
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }
};
