<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\{Waiter, Order};

class WaiterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:waiters-create')->only(['create', 'store']);
        $this->middleware('permission:waiters-read')->only(['index', 'show']);
        $this->middleware('permission:waiters-update')->only(['edit', 'update']);
        $this->middleware('permission:waiters-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waiters = Waiter::orderBy('status', 'DESC')->get();
        return view('cashier::waiters.index', compact('waiters'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Waiter $waiter)
    {
        $builder = Order::where('waiter_id', $waiter->id)->orderBy('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $status = $request->has('status') ? $request->status : 'open';
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        if ($status != 'all') {
            $builder->where('status', Order::getTypeValue($status));
        }
        
        $orders = $builder->get()->sortByDesc('status');
        return view('cashier::waiters.show', compact('waiter', 'orders', 'status', 'from_date', 'to_date'));
    }
}
