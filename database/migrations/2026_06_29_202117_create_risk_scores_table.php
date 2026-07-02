<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->integer('weather_risk')->nullable();
            $table->integer('inflation_risk')->nullable();
            $table->integer('currency_risk')->nullable();
            $table->integer('news_risk')->nullable();
            $table->integer('total')->nullable();
            $table->string('level')->nullable();
            $table->timestamp('calculated_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('risk_scores');
    }
};