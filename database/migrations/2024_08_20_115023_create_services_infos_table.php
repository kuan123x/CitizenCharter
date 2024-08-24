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
            $table->integer('step');
            $table->string('info_title');
            $table->string('clients');
            $table->string('agency_action');
            $table->double('fees', 8, 2);
            $table->string('processing_time');
            $table->double('total_fees', 8, 2);
            $table->string('total_response_time');
            $table->string('person_responsible');
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
