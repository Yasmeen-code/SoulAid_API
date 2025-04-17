<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 80)->after('Password')
                  ->unique()
                  ->nullable()
                  ->default(null);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->string('api_token', 80)->after('Password')
                  ->unique()
                  ->nullable()
                  ->default(null);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('api_token');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('api_token');
        });
    }
};