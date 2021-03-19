<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
  /**
   * Schema table name to migrate
   * @var string
   */
  public $tableName = 'drivers';

  /**
   * Run the migrations.
   * @table drivers
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('phone', 14)->nullable();
      $table->string('address', 100)->nullable();
      $table->tinyInteger('status')->default(1);
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
