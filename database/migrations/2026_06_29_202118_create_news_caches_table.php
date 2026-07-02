<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news_cache', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2)->nullable();
            $table->string('topic')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('url')->nullable();
            $table->string('source')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('sentiment')->nullable();
            $table->integer('pos_score')->default(0);
            $table->integer('neg_score')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_cache');
    }
};