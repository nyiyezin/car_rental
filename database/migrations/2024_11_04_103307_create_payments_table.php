<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->string('payment_status', 100);
            $table->decimal('paid_amount', 10, 4);
            $table->decimal('total_amount', 10, 4);
            $table->decimal('tax_amount', 10, 4);
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->decimal('late_fee', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
