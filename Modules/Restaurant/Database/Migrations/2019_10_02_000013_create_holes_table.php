<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolesTable extends Migration
{
  /**
   * Schema table name to migrate
   * @var string
   */
  public $tableName = 'halls';

  /**
   * Run the migrations.
   * @table holes
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('size')->nullable();
      $table->integer('number_of_tables')->nullable();
      $table->unsignedInteger('manager_id')->nullable();
      $table->string('phone', 14)->nullable();
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
