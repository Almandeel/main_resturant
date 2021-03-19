<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;
use App\{Item, ItemUnit};
use App\Traits\{AuthableModel, Attachable};
class Order extends Model
{
    use AuthableModel, Attachable;
    public const STATUS_OPEN = 1;
    public const STATUS_CLOSED = 2;
    public const STATUS_CANCELED = 3;
    
    public const STATUSES = [
    self::STATUS_OPEN => 'open',
    self::STATUS_CLOSED => 'closed',
    self::STATUS_CANCELED => 'canceled',
    ];
    
    public const TYPE_LOCAL = 1;
    public const TYPE_TAKEAWAY = 2;
    public const TYPE_DELIVERY = 3;
    
    public const TYPES = [
    self::TYPE_LOCAL => 'local',
    self::TYPE_TAKEAWAY => 'takeaway',
    self::TYPE_DELIVERY => 'delivery',
    ];
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'type', 'amount', 'number', 'discount', 'tax', 'status', 'closed_at', 'table_id', 'waiter_id', 'user_id', 'is_market'
    ];
    
    /**
    * Returns status value or name
    */
    public function getStatus($type = 'value'){
        if (is_null($this->closed_at)) {
            if ($type == 'name') {
                return self::STATUSES[$this->status];
            }
            return $this->status;
        }else{
            if ($type == 'name') {
                return self::STATUSES[self::STATUS_CLOSED];
            }
            return self::STATUS_CLOSED;
        }
    }
    
    public function displayStatus(){
        return __('restaurant::orders.statuses.' . $this->getStatus('name'));
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
    
    public function isOpen(){
        return $this->checkStatus('open');
    }
    
    public function isClosed(){
        return $this->checkStatus('closed');
    }
    
    public function isCanceled(){
        return $this->checkStatus('canceled');
    }
    
    // public function getTypeAttribute(){
    //     if (is_null($this->driver_id) && is_null($this->waiter_id)) {
    //         return self::TYPE_TAKEAWAY;
    //     }
    //     elseif (!is_null($this->driver_id)) {
    //         return self::TYPE_DELIVERY;
    //     }
    //     return self::TYPE_LOCAL;
    // }
    
    public function getType($type = 'value'){
        if ($type == 'name') {
            return self::TYPES[$this->type];
        }
        return $this->type;
    }
    
    public function displayType(){
        return __('restaurant::orders.types.' . $this->getType('name'));
    }
    
    public function checkType($type){
        $_type = gettype($type);
        if($_type == 'string') {
            return $this->getType('name') == $type;
        }
        
        elseif($type_type == 'integer') {
            return $this->getType() == $type;
        }
        
        throw new Exception("Unsupported type", 1);
    }
    
    public function isDelivery(){
        return $this->checkType('delivery');
    }
    
    public function close(){
        return $this->update(['status' => self::STATUS_CLOSED, 'closed_at' => now()]);
    }
    
    public function cancel(){
        return $this->update(['status' => self::STATUS_CANCELED]);
    }
    
    
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    
    public function getTotalAttribute(){
        return $this->items->sum('total');
    }
    
    public function getNetAttribute(){
        $net = $this->total;
        $net += $this->tax;
        $net -= $this->discount;
        return $net;
    }
    
    public function orderTable()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
    
    public function getHallAttribute()
    {
        if (is_null($this->orderTable)) {
            return new Hall;
        }
        return $this->orderTable->hall;
    }
    
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    
    public function waiter()
    {
        return $this->belongsTo(Waiter::class);
    }
    
    public function items()
    {
        return $this->hasMany(ItemOrder::class, 'order_id');
        // return $this->belongsToMany(ItemUnit::class)->withPivot(['quantity', 'price', 'status']);
    }
    
    public function update(array $attributes = [], array $options = []){
        $result = parent::update($attributes, $options);
        if (!array_key_exists('status', $attributes)) {
            if (!is_null($this->delivery)) {
                $this->delivery->delivered();
            }
        }
        return $result;
    }
    
    public static function create(array $attributes = []){
        if (!array_key_exists('number', $attributes)) {
            $number = static::daily()->count() + 1;
            $attributes['number'] = $number;
        }
        $order = static::query()->create($attributes);
        
        return $order;
    }
    
    public static function getTypeValue($type){
        return array_search($type, self::TYPES);
    }
    
    public static function getStatusValue($status){
        return array_search($status, self::STATUSES);
    }
    
    public static function daily(){
        return static::whereBetween('created_at', [now()->format('Y-m-d') . ' 00:00:00', now()->format('Y-m-d H:i:s')])->get();
    }
    
    public static function allOpen(){
        $orders = static::where('status', self::STATUS_OPEN);
    }
    
    public static function allClosed(){
        $orders = static::where('status', self::STATUS_CLOSED);
        return $orders->get();
    }
    
    public static function allCanceled(){
        $orders = static::where('status', self::STATUS_CANCELED);
        return $orders->get();
    }
}