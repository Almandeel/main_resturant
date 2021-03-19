<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\OrderItems;
use Modules\Restaurant\Models\{Order, ItemOrder, Delivery};

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:orders-read')->only(['index', 'show']);
        $this->middleware('permission:orders-create')->only(['store']);
        $this->middleware('permission:orders-update')->only(['update']);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $builder = Order::orderBy('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $type = $request->has('type') ? $request->type : 'local';
        $status = $request->has('status') ? $request->status : 'open';
        $status = $type == 'takeaway' && $status == 'open' ? 'closed' : $status;
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        if ($type != 'all') {
            $builder->where('type', Order::getTypeValue($type));
        }
        
        if ($status != 'all') {
            $builder->where('status', Order::getStatusValue($status));
        }
        
        $orders = $builder->get();//->sortByDesc('status');
        // dd($orders->last()->delivery);
        return view('cashier::orders.index', compact('orders', 'type', 'status', 'from_date', 'to_date'));
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Order  $order
    * @return \Illuminate\Http\Response
    */
    public function show(Order $order)
    {
        return view('cashier::orders.show', compact('order'));
    }/**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['sometimes', 'numeric', 'nullable', 'exists:tables,id'],
            'waiter_id' => ['sometimes', 'numeric', 'nullable', 'exists:waiters,id'],
            'driver_id' => ['sometimes', 'numeric', 'nullable', 'exists:drivers,id'],
            'units' => ['required', 'array'],
            'prices' => ['required', 'array'],
            'quantities' => ['required', 'array'],
            'tax' => ['numeric'],
            'discount' => ['numeric'],
        ]);
        $data = $request->only(['discount', 'tax']);
        $total = array_sum(array_map(function($x, $y) { return $x * $y; }, $request->prices, $request->quantities));
        $status = Order::STATUS_OPEN;
        $items_status = ItemOrder::STATUS_DELIVERED;
        $net = $total;
        $net += $request->tax;
        $net -= $request->discount;
        $data['amount'] = $net;
        if (!(is_null($request->delivery_name) && is_null($request->delivery_phone) && is_null($request->delivery_address) && is_null($request->driver_id)) || !(is_null($request->customer_id) && is_null($request->driver_id))) {
            $data['type'] = Order::TYPE_DELIVERY;
            if (!is_null($request->customer_id)) {
                $delivery_details = [
                'customer_id' => $request->customer_id,
                ];
            }else{
                $delivery_details = [
                'name' => $request->delivery_name,
                'phone' => $request->delivery_phone,
                'address' => $request->delivery_address,
                ];
            }
            
            $delivery_details['driver_id'] = $request->driver_id;
        }
        else if (!(is_null($request->waiter_id) && is_null($request->table_id))) {
            $data['type'] = Order::TYPE_LOCAL;
            $data['waiter_id'] = $request->waiter_id;
            $data['table_id'] = $request->table_id;
        }
        else {
            $status = Order::STATUS_CLOSED;
            $data['closed_at'] = now();
            $data['type'] = Order::TYPE_TAKEAWAY;
        }
        
        $data['status'] = $status;
        $order = Order::create($data);
        if ($order) {
            // $order->attach();
            for($i = 0; $i < count($request->units); $i++){
                $unit = $request->units[$i];
                $price = $request->prices[$i];
                $quantity = $request->quantities[$i];
                $order->items()->create([
                'item_id' => $unit,
                'quantity' => $quantity,
                'price' => $price,
                'status' => $items_status,
                ]);
            }
            
            if (isset($delivery_details)) {
                $order->delivery()->create($delivery_details);
            }
            
            session()->flash('success', 'restaurant::global.create_success');
            if ($request->has('next')) {
                // if ($request->next == 'back') {
                //     return back();
                // }else {
                //     return redirect()->to($request->next);
                // }
                return redirect()->to('/cashier/orders' . '/' . $order->id . '?view=print');
            }
            else {
                return redirect()->route('cashier.orders.index');
            }
        }
        
        return back()->with('error', 'حدث خطأ اثناء انشاء الطلب يرجى المحاولة مرة اخرى');
    }
    
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Order  $order
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Order $order)
    {
        request()->validate([
        'table_id'  => ['sometimes', 'numeric', 'nullable', 'exists:tables,id'],
        'waiter_id' => ['sometimes', 'numeric', 'nullable', 'exists:waiters,id'],
        'driver_id' => ['sometimes', 'numeric', 'nullable', 'exists:drivers,id'],
        'units'     => ['array'],
        'prices'    => ['array'],
        'quantities' => ['array'],
        'tax' => ['numeric'],
        'discount' => ['numeric'],
        ]);
        $data = $request->except(['_token', '_method']);
        if ($request->has(['units', 'quantities', 'prices'])) {
            $data = $request->only(['discount', 'tax']);
            $total = array_sum(array_map(function($x, $y) use($order) { return ($x * $y) + $order->amount; }, $request->prices, $request->quantities));
            $status = Order::STATUS_OPEN;
            $items_status = ItemOrder::STATUS_DELIVERED;
            $net = $total;
            $net += $request->tax;
            $net -= $request->discount;
            $data['amount'] = $net;
        }
        $order->update($data);
        $items = null;
        if ($request->has(['units', 'quantities', 'prices'])) {
            // dd($request->all());
            // $order->items()->delete();
            $new_items = [];
            for($i = 0; $i < count($request->units); $i++){
                $unit = $request->units[$i];
                $price = $request->prices[$i];
                $quantity = $request->quantities[$i];
                $item = $order->items()->create([
                    'item_id' => $unit,
                    'quantity' => $quantity,
                    'price' => $price,
                    'status' => $items_status,
                ]);
                array_push($new_items, $item->id);
            }
            $items = ItemOrder::whereIn('id', $new_items)->get();
        }
        
        session()->flash('success', 'restaurant::global.update_success');
        return view('cashier::orders.show', compact('order', 'items'));
        // return redirect()->to('/cashier/orders' . '/' . $order->id . '?view=print');
    }
}