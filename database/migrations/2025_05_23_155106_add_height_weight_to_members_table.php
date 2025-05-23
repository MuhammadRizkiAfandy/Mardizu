<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->integer('height')->nullable()->after('no_ktp'); // Tinggi dalam cm
            $table->integer('weight')->nullable()->after('height'); // Berat dalam kg
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['height', 'weight']);
        });
    }
};

