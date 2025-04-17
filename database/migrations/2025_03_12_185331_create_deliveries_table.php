<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('Delivery_Id');
            $table->foreignId('Donation_Id')->constrained('donations', 'Donation_Id');
            $table->date('Scheduled_Date');
            $table->string('Status', 20)->check("Status IN ('Scheduled', 'In Transit', 'Delivered', 'Cancelled')");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};