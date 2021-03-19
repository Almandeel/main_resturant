<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    public const PAYMENT_TYPE_CACH = 0;
    public const PAYMENT_TYPE_EBS = 1;

    protected $fillable = [
        'customer_id',
        'payment_type',
        'start_date',
        'end_date',
        'plan_id',
        'user_id',
        'amount',
        'canceled_at'
    ];
    
    public const PAYMENTS =  [
        self::PAYMENT_TYPE_CACH => 'نقدا',
        self::PAYMENT_TYPE_EBS => 'الكتروني',
    ];

    public function customer() {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function plan() {
        return $this->belongsTo('Modules\Subscription\Models\Plan', 'plan_id');
    }
}
