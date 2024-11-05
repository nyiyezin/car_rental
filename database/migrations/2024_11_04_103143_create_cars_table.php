<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 255)->unique();
            $table->string('model_name', 255);
            $table->integer('model_year');
            $table->float('total_kilometers');
            $table->integer('luggage_capacity');
            $table->integer('passenger_capacity');
            $table->integer('daily_rate');
            $table->integer('late_fee_per_hour');
            $table->boolean('is_available');
            $table->timestamps();
            $table->decimal('rate_per_kilometer', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
