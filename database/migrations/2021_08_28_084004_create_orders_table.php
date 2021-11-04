<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer("customers_id");
            $table->string("name");
            $table->string("email");
            $table->string("mobile");
            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("pincode");
            $table->string("coupon_code");
            $table->integer("coupon_value");
            $table->integer("order_status");
            $table->enum('payment_type',['COD','Gateway']);
            $table->string("payment_status");
            $table->string("payment_id");
            $table->string("txn_id");
            $table->integer("total_amt");
            $table->text("track_details");
            $table->datetime("added_on");
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
        Schema::dropIfExists('orders');
    }
}
