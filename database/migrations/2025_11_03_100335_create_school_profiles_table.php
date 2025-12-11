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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('school_name');
            $table->text('about')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->string('state');
            $table->string('lga');
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->enum('school_type', ['nursery', 'primary', 'secondary', 'mixed']);
            $table->enum('ownership', ['private', 'public', 'federal', 'state']);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
