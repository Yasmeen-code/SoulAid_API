<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id('Donation_Id');
            $table->decimal('Amount', 15, 2);
            $table->date('Donation_Date');
            $table->foreignId('Donor_Id')->constrained('users', 'UserId');
            $table->foreignId('Camp_Id')->nullable()->constrained('campaigns', 'Camp_Id');
            $table->foreignId('Acceptor_Id')->nullable()->constrained('users', 'UserId');
            $table->foreignId('Don_Type_Id')->constrained('donation_types', 'Don_Type_Id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};