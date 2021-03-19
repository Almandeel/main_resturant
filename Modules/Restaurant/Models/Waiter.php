<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    public const STATUS_AVAILABLE = 1;
    public const STATUS_UNAVAILABLE = 0;
    public const STATUSES = [
        self::STATUS_AVAILABLE => 'available',
        self::STATUS_UNAVAILABLE => 'unavailable',
    ];
    public const STATUSES_CLASSES = [
        self::STATUS_AVAILABLE => 'success',
        self::STATUS_UNAVAILABLE => 'warning',
    ];
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name', 'phone', 'address', 'status'
    ];
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
        $status = __('restaurant::waiters.statuses.' . $this->getStatus('name'));
        if ($format == 'html') {
            $builder = '<span class="label label-' . $this->getStatus('class') . '">';
            $builder .= $status;
            $builder .= '</span>';

            return $builder;
        }
        return $status;
    }
    
    public function checkStatus($status){
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
    
    public function orders()
    {
        return $this->hasMany(Order::class);
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