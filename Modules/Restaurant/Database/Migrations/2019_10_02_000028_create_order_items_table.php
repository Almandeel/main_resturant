<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
  /**
   * Schema table name to migrate
   * @var string
   */
  public $tableName = 'order_items';

  /**
   * Run the migrations.
   * @table order_items
   *
   * @return void
   */
  public function up()
  {
    Schema::disableForeignKeyConstraints();
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->integer('quantity');
      $table->float('price')->nullable();
      $table->unsignedInteger('order_id');
      $table->unsignedInteger('item_id');
      $table->index(["item_id"], 'fk_order_items_items1_idx');
      $table->index(["order_id"], 'fk_order_items_orders1_idx');
      $table->foreign('order_id', 'fk_order_items_orders1_idx')
        ->references('id')->on('orders')
        ->onDelete('no action')
        ->onUpdate('no action');
      $table->foreign('item_id', 'fk_order_items_items1_idx')
        ->references('id')->on('items')
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
    Schema::dropIfExists($this->tableName);
  }
}
