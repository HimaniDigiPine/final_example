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
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname');
            $table->string('surname')->nullable();
            $table->string('lastname');
            $table->string('name');
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->enum('user_type', ['admin','staff','user'])->default('user');
            $table->string('phonenumber')->unique();
            $table->string('profile_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropColumn([
                'firstname',
                'middlename',
                'lastname',
                'name',          // the generated column
                'birthdate',
                'gender',
                'user_type',
                'phonenumber',
                'profile_image',
            ]);

            // Re-add original name column
            $table->string('name');
        });
    }
};
