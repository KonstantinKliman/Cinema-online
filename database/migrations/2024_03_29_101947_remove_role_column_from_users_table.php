<?php

use App\Enums\RoleType;
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                RoleType::administrator->value,
                RoleType::uploader->value,
                RoleType::moderator->value,
                RoleType::subscriber->value,
                RoleType::verified->value,
                RoleType::user->value
            ])->default(RoleType::user);
        });
    }
};
