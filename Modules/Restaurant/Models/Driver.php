<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public const STATUS_AVAILABLE = 1;
    public const STATUS_BUSY = 2;
    public const STATUS_UNAVAILABLE = 0;
    public const STATUSES = [
    self::STATUS_AVAILABLE => 'available',
    self::STATUS_BUSY => 'busy',
    self::STATUS_UNAVAILABLE => 'unavailable',
    ];
    public const STATUSES_CLASSES = [
    self::STATUS_AVAILABLE => 'success',
    self::STATUS_BUSY => 'info',
    self::STATUS_UNAVAILABLE => 'warning',
    ];
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name', 'phone', 'address', 'status',
    ];
    
    public function getStatusAttribute($status){
        if ($this->open_orders->count()) {
            return self::STATUS_BUSY;
        }
        elseif ($status == self::STATUS_BUSY) {
            return self::STATUS_AVAILABLE;
        }
        return $status;
    }
    
    public function getStatus($type = 'value'){
        if ($type == 'name') {
            return self::STATUSES[$this->status];
        }
        elseif ($type == 'class') {
            return self::STATUSES_CLASSES[$this->status];
        }
        return $this->status;
    }
    
    public function displayStatus($format = 'none'){
        $status = __('restaurant::drivers.statuses.' . $this->getStatus('name'));
        if ($format == 'label') {
            $builder = '<span class="label label-' . $this->getStatus('class') . '">';
            $builder .= $status;
            $builder .= '</span>';
            
            return $builder;
        }
        else if ($format == 'text') {
            $builder = '<span class="text-' . $this->getStatus('class') . '">';
            $builder .= $status;
            $builder .= '</span>';
            
            return $builder;
        }
        return $status;
    }
    
    public function checkStatus($status){
        $status_type = gettype($status);
        if ($status_type == 'string') {
            return $this->getStatus('name') == $status;
        }
        
        elseif ($status_type == 'integer') {
            return $this->getStatus() == $status;
        }
        
        throw new Exception("Unsupported status type", 1);
    }
    
    public function isAvailable(){
        return $this->checkStatus('available');
    }
    
    public function isUnavailable(){
        return $this->checkStatus('unavailable');
    }
    
    public function isBusy(){
        return $this->checkStatus('busy');
    }
    
    
    public function getOrdersAttribute()
    {
        $orders = new Collection();
        foreach ($this->deliveries as $delivery) {
            $orders->push($delivery->order);
        }
        return $orders;
    }
    
    public function getOpenOrdersAttribute(){
        return $this->orders->where('status', Order::STATUS_OPEN);
    }
    
    
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
    
    public static function allAvailable(){
        $orders = static::where('status', self::STATUS_AVAILABLE);
        return $orders->get();
    }
    
    public static function allUnavailable(){
        $orders = static::where('status', self::STATUS_UNAVAILABLE);
        return $orders->get();
    }
}