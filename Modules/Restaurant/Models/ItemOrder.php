<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;
use App\{Item, ItemUnit, Unit};
class ItemOrder extends Model
{

    public const STATUS_WAITING = 0;
    public const STATUS_DELIVERED = 1;
    public const STATUS_CANCELED = 2;
    
    public const STATUSES = [
        self::STATUS_WAITING => 'waiting',
        self::STATUS_DELIVERED => 'delivered',
        self::STATUS_CANCELED => 'canceled',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'price', 'order_id', 'item_id',
    ];

    protected $table = 'item_order';

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
        return __('restaurant::orders.statuses.items.' . $this->getStatus('name'));
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

    public function getNameAttribute(){
        return $this->item->name . '-' . $this->unit->name;
    }

    public function getTotalAttribute(){
        return $this->price * $this->quantity;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class, 'item_id');
    }
    
    public function item(){
        return $this->itemUnit->belongsTo(Item::class);
    }
    
    public function unit(){
        return $this->itemUnit->belongsTo(Unit::class);
    }
}
