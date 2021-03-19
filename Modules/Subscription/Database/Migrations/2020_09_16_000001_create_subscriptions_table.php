<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'subscriptions';

    /**
     * Run the migrations.
     * @table subscriptions
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->tinyInteger('payment_type')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('canceled_at')->nullable();
            $table->unsignedInteger('plan_id');
            $table->double('amount');

            $table->index(["plan_id"], 'fk_subscriptions_plan_idx');
            $table->index(["customer_id"], 'fk_subscriptions_customer_idx');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plan_id', 'fk_subscriptions_plan_idx')
                ->references('id')->on('plans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('customer_id', 'fk_subscriptions_customer_idx')
            ->references('id')->on('customers')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::enableForeignKeyConstraints();
        \DB::statement('ALTER TABLE subscriptions AUTO_INCREMENT = 100;');
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
