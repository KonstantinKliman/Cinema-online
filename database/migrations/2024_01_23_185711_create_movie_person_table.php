<?php

use App\Models\Movie;
use App\Models\Person;
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
        Schema::create('movie_person', function (Blueprint $table) {
            $table->foreignIdFor(Movie::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Person::class)->constrained('persons')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('role', ['director', 'producer', 'actor', 'screenwriter', 'cameraman', 'composer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_person');
    }
};
