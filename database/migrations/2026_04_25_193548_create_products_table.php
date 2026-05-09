<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // একটা product এর multiple images JSON এ store হবে
            // ["images/p1.jpg", "images/p2.jpg", "images/p3.jpg"]
            $table->json('gallery')->nullable()->after('image');

            // Azlan page এর বাকি fields
            $table->string('subtitle')->nullable()->after('description');
            $table->string('badge')->nullable()->after('subtitle');
            $table->text('fabric_care')->nullable()->after('badge');
            $table->text('delivery_info')->nullable()->after('fabric_care');
            $table->json('sizes')->nullable()->after('delivery_info');
            $table->json('unavailable_sizes')->nullable()->after('sizes');
            $table->json('colors')->nullable()->after('unavailable_sizes');
            $table->decimal('rating', 2, 1)->default(0)->after('colors');
            $table->integer('reviews_count')->default(0)->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'gallery',
                'subtitle',
                'badge',
                'fabric_care',
                'delivery_info',
                'sizes',
                'unavailable_sizes',
                'colors',
                'rating',
                'reviews_count',
            ]);
        });
    }
};