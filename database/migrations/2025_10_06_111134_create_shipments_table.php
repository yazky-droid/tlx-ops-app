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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('shipper_id')->constrained('clients');
            $table->foreignId('consignee_id')->constrained('clients');
            $table->string('service_type')->default('Air Freight');
            $table->string('destination_port');
            $table->string('cargo_description');
            $table->decimal('weight_kg', 8, 2)->default(0);
            $table->decimal('volume_cbm', 8, 3)->default(0);
            $table->decimal('goods_value', 12, 2)->default(0);
            $table->text('cargo_condition')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->string('current_status')->default('Booked');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
