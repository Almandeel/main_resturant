<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelHasPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_has_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('subplan_id');

            $table->index(["plan_id"]);
            $table->index(["subplan_id"]);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plan_id')
                ->references('id')->on('plans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subplan_id')
            ->references('id')->on('plans')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_plans');
    }
}
