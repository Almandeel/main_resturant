<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'price', 'order_id', 'item_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
