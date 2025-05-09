<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtToPersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('campaign_id');
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('rating')->nullable(); // من 1 إلى 5 مثلاً
            $table->timestamps();
    
            $table->foreign('user_id')->references('UserId')->on('users')->onDelete('cascade');
            $table->foreign('campaign_id')->references('Camp_Id')->on('campaigns')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
}
