<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'deliveries';

    /**
     * Run the migrations.
     * @table deliveries
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('driver_id')->nullable();
            
            $table->index('driver_id', 'fk_deliveries_drivers1_idx');
            $table->index('order_id', 'fk_deliveries_orders1_idx');
            $table->index('customer_id', 'fk_deliveries_customers1_idx');
            
            $table->foreign('customer_id', 'fk_deliveries_customers1_idx')
                ->references('id')->on('customers')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('order_id', 'fk_deliveries_orders1_idx')
                ->references('id')->on('orders')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('driver_id', 'fk_deliveries_drivers1_idx')
                ->references('id')->on('drivers')
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
