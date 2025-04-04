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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamp('date')->nullable(); //Tanggal pencatatan
            $table->float('hours_spent', 8, 2); //Jumlah jam kerja
            $table->float('hourly_rate', 8, 2);
            $table->float('addtional_charges', 8, 2)->nullable();
            $table->float('total_remunation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
