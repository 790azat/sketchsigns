<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['products', 'categories'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->string('seo_title')->nullable();
                $table->string('seo_description', 500)->nullable();
            });
        }

        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('from_path')->unique();
            $table->string('to_path', 1024);
            $table->unsignedSmallInteger('status_code')->default(301);
            $table->unsignedInteger('hits')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');

        foreach (['products', 'categories'] as $name) {
            Schema::table($name, fn (Blueprint $table) => $table->dropColumn(['seo_title', 'seo_description']));
        }
    }
};
