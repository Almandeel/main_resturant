<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Customer;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Driver;
use Modules\Restaurant\Models\Menu;
use Modules\Restaurant\Models\Order;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Models\Waiter;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:orders-create')->only(['create', 'store']);
        $this->middleware('permission:orders-read')->only(['index', 'show']);
        $this->middleware('permission:orders-update')->only(['edit', 'update']);
        $this->middleware('permission:orders-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('restaurant::orders.index', compact('orders', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all()->map(function ($menu) {
            return [$menu->id => $menu->name];
        });

        $items = Item::all();

        return view('restaurant::orders.create', compact('menus', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['sometimes', 'numeric', 'exists:tables,id'],
            'waiter_id' => ['sometimes', 'numeric', 'exists:waiters,id'],
            'driver_id' => ['sometimes', 'numeric', 'exists:drivers,id'],
            'items' => ['required', 'array'],
            'items.*.*' => ['sometimes', 'numeric', 'exists:items,id'],
        ]);

        $order = Order::create(array_merge($request->all(), ['type' => 3, 'amount' => array_sum($request->price) ?? 0]));
        if ($order) {
            $order->attach();
            foreach ($request->items as $key => $id) {
                $order->items()->create([
                    'item_id' => $id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                ]);
            }
    
            if ($request->filled(['table_id', 'waiter_id'])) {
                // Local order (in restaurant)
                $order->update(['type' => 1]);
                Table::find($request->table_id)->update(['status' => 1]);
                Waiter::find($request->waiter_id)->update(['status' => 1]);
            } elseif ($request->filled('driver_id')) {
                // Delivery
                $order->update(['type' => 2]);
                Driver::find($request->driver_id)->update(['status' => 1]);
                // TODO: Check this 
                // Customer::create($request->customer); 
            } else {
                // Take-away (by customer)
                $order->update(['status' => 0, 'closed_at' => now()]);
            }
    
            session()->flash('success', 'restaurant::global.create_success');
    
            if ($request->next == 'back') {
                return back();
            } else {
                return redirect()->route('orders.index');
            }
        }

        return back()->with('error', 'حدث خطأ اثناء انشاء الطلب يرجى المحاولة مرة اخرى');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('restaurant::orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $items = Item::all();
        return view('restaurant::orders.edit', compact('order', 'items'));
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
            'status' => ['sometimes', 'numeric', 'between:0,5'],
            'table_id' => ['sometimes', 'numeric', 'exists:tables,id'],
            'waiter_id' => ['sometimes', 'numeric', 'exists:waiters,id'],
            'driver_id' => ['sometimes', 'numeric', 'exists:drivers,id'],
            'items' => ['sometimes', 'array'],
            'items.*.*' => ['sometimes', 'numeric', 'exists:items,id'],
        ]);

        $order->update($request->all());

        if ($request->has(['items', 'quantity', 'price'])) {
            $order->items()->delete();

            foreach ($request->items as $key => $id) {
                $order->items()->create([
                    'item_id' => $id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                ]);
            }
        }

        if ($request->status == 1) {
            // 
        } elseif ($request->status == 4) {
            // Order is canceld TODO: Check this
        } elseif ($request->status == 5) {
            // Order is completed succussfully
            if ($order->type == 2) {
                $order->driver()->update(['status' => 0]);
            } elseif ($order->type == 1) {
                $order->waiter()->update(['status' => 0]);
                $order->table()->update(['status' => 0]);
            }

            $order->update(['status' => 0, 'closed_at' => now()]);
        }


        session()->flash('success', 'restaurant::global.update_success');

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        session()->flash('success', 'restaurant::global.delete_success');

        return redirect()->route('orders.index');
    }
}
