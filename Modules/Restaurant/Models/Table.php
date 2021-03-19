<?php

namespace Modules\Restaurant\Models;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
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
    'id', 'number', 'status', 'hall_id',
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
        $status = __('restaurant::tables.statuses.' . $this->getStatus('name'));
        if ($format == 'html') {
            $builder = '<span class="label label-' . $this->getStatus('class') . '">';
            $builder .= $status;
            $builder .= '</span>';
            
            return $builder;
        }
        return $status;
    }
    
    public function getOpenOrdersAttribute(){
        return $this->orders->where('status', Order::STATUS_OPEN);
    }
    
    public function openOrders(){
        return $this->orders->where('status', Order::STATUS_OPEN);
    }
    
    public function closedOrders(){
        return $this->orders->where('status', Order::STATUS_CLOSED);
    }
    
    public function canceledOrders(){
        return $this->orders->where('status', Order::STATUS_CANCELED);
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
    
    public function isBusy(){
        return $this->checkStatus('busy');
    }
    
    public function isUnavailable(){
        return $this->checkStatus('unavailable');
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function waiter()
    {
        return $this->belongsTo(Waiter::class);
    }
    
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
    
    public static function boot(){
        parent::boot();
        static::creating(function($table){
            if (is_null($table->number)) {
                $table->id = Table::all()->count() + 1;
                $table->number = $table->id;
            }
        });
    }
    
    public static function allAvailable(){
        return static::with(['orders' => function($query) {
            $query->where('status', '!=', Order::STATUS_OPEN)
            ->whereNull('closed_at');
        }
        ])->get();
    }
}