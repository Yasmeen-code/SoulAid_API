<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id('Camp_Id');
            $table->string('CampName');
            $table->text('Description');
            $table->date('StartDate');
            $table->date('EndDate');
            $table->string('Image')->nullable();
            $table->decimal('Amount', 10, 2);
            $table->string('Address');
            $table->foreignId('Admin_Id')->constrained('admins', 'Admin_Id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};