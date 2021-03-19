<?php

namespace Modules\Subscription\Models;

use Modules\Subscription\Models\Plan;
use Illuminate\Database\Eloquent\Model;

class ModelHasPlan extends Model
{
    protected $fillable = ['plan_id', 'subplan_id'];

    public function plan() {
        return $this->belongsTo(Plan::class, 'subplan_id');
    }
}
