<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->date('order_date');
            $table->date('ship_date')->nullable();
            $table->decimal('ship_amount', 10, 2)->default(0.00);
            $table->string('phone_receiver');
            $table->string('ship_address');
            $table->string('billing_address');
            $table->string('status')->default('Pending');
            $table->foreign('user_id')->references('id')->on('users');
            //$table->softDeletes();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
