<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('genba_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('priority', ['c', 'b', 'a']);
            $table->string('pic');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('genba_events');
    }
};