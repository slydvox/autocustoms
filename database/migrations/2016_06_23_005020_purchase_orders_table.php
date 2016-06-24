<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purpose');
            $table->string('type');
            $table->string('number');
            $table->string('date');
            $table->string('purchaser');
            $table->string('currency_code');
            $table->integer('terms_type_code');
            $table->integer('terms_basis_date_code');
            $table->string('date_time_qualifier');
            $table->string('qualifier_date');
            $table->string('transportation_type_code');
            $table->string('routing');
            $table->string('service_level_code_1');
            $table->string('service_level_code_2');
            $table->integer('vendor_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('bill_to_id')->unsigned();
            $table->integer('ship_to_id')->unsigned()->nullable();
            $table->integer('sold_to_id')->unsigned()->nullable();
            $table->string('assigned_id');
            $table->integer('quantity');
            $table->string('unit_measure');
            $table->decimal('unit_price', 10,2);
            $table->string('id_qualifier');
            $table->string('item_id');
            $table->string('id_qualifier2');
            $table->string('item_id2');
            $table->string('code');
            $table->string('item_description_code');
            $table->string('item_class_code');
            $table->string('item_description');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('bill_to_id')->references('id')->on('addresses');
            $table->foreign('ship_to_id')->references('id')->on('addresses');
            $table->foreign('sold_to_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchase_orders');
    }
}
