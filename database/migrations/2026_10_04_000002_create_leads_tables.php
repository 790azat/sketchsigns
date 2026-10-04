<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('status')->default('new');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->string('delivery');
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->json('items');
            $table->unsignedInteger('subtotal'); // cents
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('new');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('product')->nullable();
            $table->string('size')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->date('needed_by')->nullable();
            $table->text('details');
            $table->string('artwork_link', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('orders');
    }
};
