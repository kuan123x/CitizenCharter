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
        Schema::create('services_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            // $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->integer('step');
            $table->string('info_title');
            $table->json('clients');
            $table->json('agency_action');
            $table->double('fees', 8, 2);
            $table->json('processing_time');
            $table->json('person_responsible');
            $table->double('total_fees', 8, 2);
            $table->string('total_response_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_infos');
    }
};
