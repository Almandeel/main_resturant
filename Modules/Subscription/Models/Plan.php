<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Subscription\Models\ModelHasPlan;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'period'
    ];

    public function subPlans() {
        return $this->hasMany(ModelHasPlan::class);
    }
}
