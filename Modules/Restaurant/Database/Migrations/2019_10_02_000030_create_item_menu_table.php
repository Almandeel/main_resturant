<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemMenuTable extends Migration
{
  /**
   * Schema table name to migrate
   * @var string
   */
  public $tableName = 'item_menu';

  /**
   * Run the migrations.
   * @table item_menu
   *
   * @return void
   */
  public function up()
  {
    Schema::disableForeignKeyConstraints();
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('menu_id');
      $table->unsignedInteger('item_id');
      $table->tinyInteger('status')->default(0);
      $table->foreign('menu_id', 'fk_item_menu_menus1_idx')
        ->references('id')->on('menus')
        ->onDelete('no action')
        ->onUpdate('no action');
      $table->foreign('item_id', 'fk_item_menu_items1_idx')
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
