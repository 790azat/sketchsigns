<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('source_url', 1024)->unique();
            $table->string('url', 1024);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_id')->nullable()->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image', 1024)->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_id')->nullable()->unique();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('type')->default('simple');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('price_min')->default(0); // cents
            $table->unsignedInteger('price_max')->default(0); // cents
            $table->string('image', 1024)->nullable();
            $table->json('gallery')->nullable();
            $table->json('options')->nullable(); // [{name, terms: [{slug, name}]}]
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->primary(['category_id', 'product_id']);
        });

        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('wp_id')->nullable()->unique();
            $table->json('options'); // {"Size": "24-x-6", "Graphic": ""} — "" matches any value
            $table->unsignedInteger('price'); // cents
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variations');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('media');
    }
};
