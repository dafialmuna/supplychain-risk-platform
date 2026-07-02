<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('base', 3);
            $table->string('target', 3);
            $table->decimal('rate', 15, 6);
            $table->date('date');
            $table->timestamps();
            $table->unique(['base', 'target', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
};