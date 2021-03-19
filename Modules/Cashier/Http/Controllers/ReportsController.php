<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\{Order, ItemOrder, Delivery, Waiter, Driver};
use App\User;
class ReportsController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index()
    {
        return view('cashier::reports.index');
    }
    
    public function orders(Request $request)
    {
        $type = $request->has('type') ? $request->type : 'local';
        
        $builder = Order::with('items')->orderBy('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $status = $request->has('status') ? $request->status : 'closed';
        // $status = $type == 'takeaway' && $status == 'open' ? 'closed' : $status;
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        $builder->where('type', Order::getTypeValue($type));
        
        $users = User::all();
        $user_id = $request->has('user_id') ? $request->user_id : 'all';
        $compact = compact('from_date', 'to_date', 'status', 'type', 'users', 'user_id');
        
        if ($user_id != 'all') {
            $builder->where('user_id', $user_id);
        }
        
        if ($status != 'all') {
            $builder->where('status', Order::getStatusValue($status));
        }
        
        $title = 'التقارير';
        if ($type == 'local') {
            $title .= ' | طلبات محلي';
            $compact['title'] = $title;
            $icon = 'icon-waiter';
            $compact['icon'] = $icon;
            
            $waiters = Waiter::all();
            $compact['waiters'] = $waiters;
            
            $waiter_id = $request->has('waiter_id') ? $request->waiter_id : 'all';
            $compact['waiter_id'] = $waiter_id;
            if ($waiter_id != 'all') {
                $builder->where('waiter_id', $waiter_id);
            }
            
            $orders = $builder->get();
            $compact['orders'] = $orders;
            
        }
        elseif ($type == 'takeaway') {
            $title .= ' | طلبات سفري';
            $compact['title'] = $title;
            $icon = 'icon-takeaway';
            $compact['icon'] = $icon;
            
            $orders = $builder->get();
            $compact['orders'] = $orders;
            
        }
        elseif ($type == 'delivery') {
            $title .= ' | طلبات توصيل';
            $compact['title'] = $title;
            $icon = 'icon-delivery';
            $compact['icon'] = $icon;
            
            $drivers = Driver::all();
            $compact['drivers'] = $drivers;
            
            $driver_id = $request->has('driver_id') ? $request->driver_id : 'all';
            $deliveries = Delivery::with('order')->whereBetween('created_at', [$from_date_time, $to_date_time]);
            $compact['driver_id'] = $driver_id;
            if ($driver_id != 'all') {
                $deliveries->where('driver_id', $driver_id);
            }
            
            $orders = $deliveries->get()->map(function($delivery){
                $order = $delivery->order;
                $order->driver = $delivery->driver;
                return $order;
            });
            $compact['orders'] = $orders;
            
        }
        
        if ($from_date != $to_date) {
            $title .= ' ' . $from_date . ' : ' . $to_date;
        }else{
            $title .= ' ' . $from_date;
        }
        $compact['title'] = $title;
        return view('cashier::reports.orders', $compact);
    }
}