<?php

use Modules\Restaurant\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateOrdersTable extends Migration
{
  /**
   * Schema table name to migrate
   * @var string
   */
  public $tableName = 'orders';

  /**
   * Run the migrations.
   * @table orders
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->integer('number')->nullable();
      $table->tinyInteger('type')->default(Order::TYPE_LOCAL);
      $table->float('amount')->nullable();
      $table->float('discount')->nullable()->default(0);
      $table->float('tax')->nullable()->default(0);
      $table->tinyInteger('status')->default(Order::STATUS_OPEN);
      $table->timestamp('closed_at')->nullable();
      $table->unsignedInteger('table_id')->nullable();
      $table->unsignedInteger('waiter_id')->nullable();
      // $table->unsignedInteger('driver_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->tinyInteger('is_market')->default(0);

      $table->foreign('table_id')->references('id')->on('tables')
        ->onDelete('cascade');
      // $table->foreign('driver_id')->references('id')->on('drivers')
      //   ->onDelete('cascade');
      $table->foreign('waiter_id')->references('id')->on('waiters')
        ->onDelete('cascade');

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
    Schema::dropIfExists($this->tableName);
  }
}
