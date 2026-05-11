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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('payment_method')->nullable()->after('delivery_type');
        $table->string('payment_status')->nullable()->after('payment_method');
        $table->string('transaction_id')->nullable()->after('payment_status');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['payment_method', 'payment_status', 'transaction_id']);
    });
}
};
