<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('role')->nullable(); // Ruolo
            $table->integer('rare_drops_system')->default(0); // Drop rari assegnati da sistema
            $table->integer('super_rare_drops_system')->default(0); // Drop super rari assegnati da sistema
            $table->boolean('kept_rare_drop')->default(false); // Ha mantenuto il drop raro
            $table->boolean('kept_super_rare_drop')->default(false); // Ha mantenuto il drop super raro
            $table->integer('redistributed_rare_drop')->default(0); // Drop Raro Redistribuito
            $table->integer('redistributed_super_rare_drop')->default(0); // Drop Super Raro Redistribuito
            $table->integer('received_rare_drop')->default(0); // Ha ricevuto drop raro redistribuito
            $table->integer('received_super_rare_drop')->default(0); // Ha ricevuto drop super raro redistribuito
            $table->integer('total_rare_dropped')->default(0); // Totale drop rari droppati (calcolato)
            $table->integer('total_rare_system')->default(0); // Totale drop rari assegnati da sistema (calcolato)
            $table->integer('total_rare_distributed')->default(0); // Totale drop rari distribuiti (calcolato)
            $table->integer('priority')->default(0); // Priorità
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'rare_drops_system', 'super_rare_drops_system',
                'kept_rare_drop', 'kept_super_rare_drop', 'redistributed_rare_drop',
                'redistributed_super_rare_drop', 'received_rare_drop',
                'received_super_rare_drop', 'total_rare_dropped',
                'total_rare_system', 'total_rare_distributed', 'priority'
            ]);
        });
    }
};