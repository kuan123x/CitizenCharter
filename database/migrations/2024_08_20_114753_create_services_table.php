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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('description');
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->enum('classification', ['SIMPLE', 'COMPLEX', 'SIMPLE - COMPLEX', 'HIGHLY TECHNICAL']);
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->string('checklist_of_requirements');
            $table->string('where_to_secure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
