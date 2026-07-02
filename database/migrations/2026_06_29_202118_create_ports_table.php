<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('country_code', 2);
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->string('type')->nullable();
            $table->string('region')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ports');
    }
};