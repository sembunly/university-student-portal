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
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 30)->unique();
            $table->string('name_km', 100);
            $table->string('name_en', 100);
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 20);
            $table->string('nationality', 100)->nullable();
            $table->string('phone', 30);
            $table->string('email')->nullable();

            $table->unsignedInteger('current_province_id');
            $table->unsignedInteger('current_district_id');
            $table->unsignedInteger('current_commune_id');
            $table->unsignedInteger('current_village_id');
            $table->string('current_house', 50)->nullable();
            $table->string('current_street', 100)->nullable();

            $table->unsignedInteger('permanent_province_id');
            $table->unsignedInteger('permanent_district_id');
            $table->unsignedInteger('permanent_commune_id');
            $table->unsignedInteger('permanent_village_id');
            $table->string('permanent_house', 50)->nullable();
            $table->string('permanent_street', 100)->nullable();

            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_phone', 30)->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_phone', 30)->nullable();
            $table->string('emergency_name');
            $table->string('emergency_phone', 30);

            $table->string('high_school')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->unsignedInteger('education_province_id')->nullable();
            $table->string('certificate_path')->nullable();
            $table->timestamps();

            $table->foreign('current_province_id')->references('id')->on('provinces')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('current_district_id')->references('id')->on('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('current_commune_id')->references('id')->on('communes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('current_village_id')->references('id')->on('villages')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('permanent_province_id')->references('id')->on('provinces')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('permanent_district_id')->references('id')->on('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('permanent_commune_id')->references('id')->on('communes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('permanent_village_id')->references('id')->on('villages')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('education_province_id')->references('id')->on('provinces')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
