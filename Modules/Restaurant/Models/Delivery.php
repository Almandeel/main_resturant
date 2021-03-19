<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
class Delivery extends Model
{
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'fees', 'name', 'phone', 'address', 'customer_id', 'order_id', 'driver_id'
    ];
    
    public function delivered(){
        return $this->driver->update(['status' => Driver::STATUS_AVAILABLE]);
    }
    
    public static function create(array $attributes = []){
        $delivery = static::query()->create($attributes);
        if ($delivery) {
            $delivery->driver->update(['status' => Driver::STATUS_BUSY]);
        }
        
        return $delivery;
    }
    
    
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public static function boot(){
        parent::boot();
        static::saved(function($delivery){
            if($delivery->wasRecentlyCreated){
                $delivery->driver->update(['status' => Driver::STATUS_BUSY]);
            }
        });
    }
    
}