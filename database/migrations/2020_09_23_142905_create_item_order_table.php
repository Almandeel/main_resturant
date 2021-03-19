<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('item_order', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('quantity');
            $table->float('price')->nullable();
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('item_id');
            $table->tinyInteger('status')->default(0);
            $table->index(["item_id"], 'fk_item_order_items_idx');
            $table->index(["order_id"], 'fk_item_order_orders_idx');
            $table->foreign('order_id', 'fk_item_order_orders_idx')
                ->references('id')->on('orders')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('item_id', 'fk_item_order_items_idx')
                ->references('id')->on('item_unit')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_order');
    }
}
