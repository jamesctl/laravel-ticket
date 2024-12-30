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
            $table->bigInteger('reply_ticket_id')->unsigned()->nullable()->after('ticket_id');
            //$table->foreign('reply_ticket_id')->references('id')->on('reply_tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            //$table->dropForeign(['reply_ticket_id']);
            $table->dropColumn(['reply_ticket_id']);
        });
    }
};
