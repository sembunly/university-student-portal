<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_accounts', function (Blueprint $table) {
            $table->string('student_id', 30)->nullable()->change();
            $table->string('phone', 20)->nullable()->unique()->after('student_id');
        });
    }

    public function down(): void
    {
        Schema::table('student_accounts', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn('phone');
            $table->string('student_id', 30)->nullable(false)->change();
        });
    }
};
