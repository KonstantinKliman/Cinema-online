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
        Schema::rename('comments', 'reviews');

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->string('title', 255);
            $table->text('review');
            $table->enum('type', [0, 1, 2]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('content');
            $table->dropColumn('title');
            $table->dropColumn('review');
            $table->dropColumn('type');
        });

        Schema::rename('reviews', 'comments');
    }
};
