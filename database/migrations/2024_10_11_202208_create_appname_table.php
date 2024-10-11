<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('appname', function (Blueprint $table) {
            $table->id();
            $table->string('appName');
            $table->string('appVersion');
            $table->text('appDescription');
            $table->string('appID');
            $table->string('productName');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appname');
    }
};
