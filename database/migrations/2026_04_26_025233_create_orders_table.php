<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('first_name')->nullable()->after('user_id');
        $table->string('last_name')->nullable()->after('first_name');
        $table->string('email')->nullable()->after('last_name');
        $table->string('phone')->nullable()->after('email');
        $table->string('city')->nullable()->after('phone');
        $table->string('state')->nullable()->after('city');
        $table->string('zip_code')->nullable()->after('state');
        $table->text('address')->nullable()->after('zip_code');
        $table->string('shipping_method')->nullable()->after('address');
        $table->decimal('shipping_cost', 10, 2)->default(0)->after('shipping_method');
        $table->decimal('subtotal', 10, 2)->default(0)->after('shipping_cost');
        $table->decimal('total', 10, 2)->default(0)->after('subtotal');
        $table->string('payment_method')->nullable()->after('total');
        $table->string('payment_status')->default('pending')->after('payment_method');
        $table->string('order_status')->default('pending')->after('payment_status');
        $table->string('transaction_id')->nullable()->after('order_status');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'first_name','last_name','email','phone','city','state',
            'zip_code','address','shipping_method','shipping_cost',
            'subtotal','total','payment_method','payment_status',
            'order_status','transaction_id'
        ]);
    });
}
};
