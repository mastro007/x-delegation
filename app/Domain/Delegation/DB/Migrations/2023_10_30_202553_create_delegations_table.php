<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delegations', function (Blueprint $table) {
            $table->id();
            $table->char('worker_id', 32);
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('amount_due')->unsigned();
            $table->char('country', 2)->index();
            $table->char('currency', 3)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegations');
    }
};
