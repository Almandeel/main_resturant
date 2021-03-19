<?php

namespace Modules\Cashier\Http\Controllers;

use App\{Item, ItemUnit};
use Illuminate\Http\Request;
use App\{Account, Entry, Safe};
use App\{Employee, Transaction};
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscription\Models\Subscription;
use Modules\Restaurant\Models\{Menu, Waiter, Driver, Table, Order};

class CashierController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index()
    {
        return view('cashier::index');
    }
    
    public function pos(Request $request)
    {
        $waiters = Waiter::allAvailable();
        $menus_collection = Menu::all();
        $menus_keys = $menus_collection->modelKeys();
        $menus_data = $menus_collection->map(function($menu){
            $menu_data = $menu->getAttributes();
            $menu_data['items'] = array_combine($menu->items->pluck('name')->toArray(), $menu->items->map(function($item){
                $units = [];
                foreach ($item->itemUnits->where('status', ItemUnit::STATUS_AVAILABLE) as $unit) {
                    $units[] = [
                    'id' => $unit->id,
                    'name' => $unit->item->name . '-' . $unit->unitName(),
                    'image_url' => $item->image_url,
                    'item_name' => $item->name,
                    'unit_name' => $unit->unitName(),
                    'price' => $unit->price,
                    'status' => [
                    'name' => $unit->status_name,
                    'title' => $unit->status_title,
                    'class' => $unit->status_class,
                    ],
                    ];
                }
                return $units;
            })->toArray());
            return $menu_data;
        })->toArray();
        $menus = array_combine($menus_keys, $menus_data);
        // dd($menus);
        $order = Order::find($request->order_id);
        $tables = Table::allAvailable();
        /*->map(function($table){
        $data = [
        'id' => $table->id,
        'number' => $table->number,
        ];
        return array_merge($data, []);
        });*/
        $drivers = Driver::allAvailable();
        // dd($order->items->first()->item);
        return view('cashier::pos', compact('waiters', 'menus', 'order', 'tables', 'drivers'));
    }
    
    public function safe(Request $request)
    {
        $user = auth()->user();
        $cashier = $user->employee;
        $account = $cashier->account;
        $builder = Order::where('user_id', $user->id)->orderBy('updated_at');
        $builder_subscription = Subscription::where('user_id', $user->id)->orderBy('updated_at');
        $date = $request->has('date') ? $request->date : date('Y-m-d');
        $to_date = $date;
        
        $type = $request->has('type') ? $request->type : 'all';
        $status = $request->has('status') ? $request->status : 'all';
        $status = $type == 'takeaway' && $status == 'open' ? 'closed' : $status;
        
        $date_time = $date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$date_time, $to_date_time]);

        $builder_subscription->whereBetween('created_at', [$date_time, $to_date_time]);

        
        if ($type != 'all') {
            $builder->where('type', Order::getTypeValue($type));
        }
        
        if ($status != 'all') {
            $builder->where('status', Order::getStatusValue($status));
        }
        // dd($user->orders->whereBetween('created_at', [$date_time, $to_date_time])->pluck('status'));
        $orders = $builder->get();
        $orders = $orders->sortByDesc('status');
        /*->groupBy(function($order) {
        return Carbon::parse($order->created_at)->format('Y-m-d');
        });*/

        $subscriptions = $builder_subscription->get();
        
        $daily_entries = $cashier->dailyEntries($date);
        $opening_entry = $cashier->openingEntry($date);
        $close_entry = $cashier->closeEntry($date);
        // dd($daily_entries, $opening_entry, $close_entry, $adjust_entry);
        $accounts = Account::where('id', '!=', $account->id)->get();
        $safes = Safe::all();
        $closing_amount = $orders->sum('amount') + $subscriptions->sum('amount');
        $closing_amount += $opening_entry ? $opening_entry->amount : 0;
        $deducation = null;
        if ($close_entry) {
            $close_date_time = $close_entry->created_at;
            $close_date_time_plus_2_minutes = $close_entry->created_at->addMinutes(2);
            $deducation = Transaction::where('employee_id', $cashier->id)->where('type', Transaction::TYPE_DEDUCATION)->whereBetween('created_at', [$close_date_time->toDateTimeString(), $close_date_time_plus_2_minutes->toDateTimeString()])->first();
        }
        return view('cashier::safe', compact('cashier', 'user', 'orders', 'safes', 'accounts', 'account', 'deducation', 'type', 'status', 'date', 'closing_amount', 'to_date', 'daily_entries', 'opening_entry', 'close_entry', 'subscriptions'));
    }
}