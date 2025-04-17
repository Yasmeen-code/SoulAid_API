<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id('Request_Id');
            $table->foreignId('Acceptor_Id')->constrained('users', 'UserId')->onDelete('cascade');
            $table->foreignId('Don_Type_Id')->constrained('donation_types', 'Don_Type_Id')->onDelete('cascade');
            $table->decimal('Amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('Status', 20);
            $table->date('Date');
            $table->text('Level_Of_Need')->nullable();
            $table->foreignId('Admin_Id')->nullable()->constrained('admins', 'Admin_Id')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};