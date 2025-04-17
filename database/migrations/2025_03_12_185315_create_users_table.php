<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserId');
            $table->string('Name', 88);
            $table->string('Email', 155)->unique();
            $table->string('Password', 106);
            $table->text('Image')->nullable();
            $table->text('Address')->nullable();
            $table->string('UserType', 10)->check("UserType IN ('Donor', 'Acceptor')");
            $table->foreignId('Admin_Id')->nullable()->constrained('admins', 'Admin_Id')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};