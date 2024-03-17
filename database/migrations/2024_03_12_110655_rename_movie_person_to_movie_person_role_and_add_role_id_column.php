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
        Schema::rename('movie_person', 'movie_person_role');
        Schema::table('movie_person_role', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('person_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_person_role', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->enum('role', ['director', 'producer', 'actor', 'screenwriter', 'cameraman', 'composer']);
        });
        Schema::rename('movie_person_role', 'movie_person');
    }
};
