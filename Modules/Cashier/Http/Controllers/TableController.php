<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\{Table, Order};
class TableController extends Controller
{
    /**
    * Check if user have permission in every request
    *
    * @return Response
    * @throws \Illuminate\Auth\Access\AuthorizationException
    */
    public function __construct()
    {
        $this->middleware('permission:tables-read')->only(['index', 'show']);
        $this->middleware('permission:tables-update')->only(['update']);
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $tables = Table::all();
        return  view('cashier::tables.index', compact('tables'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Table $table)
    {
        $builder = Order::where('table_id', $table->id)->orderBy('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $status = $request->has('status') ? $request->status : 'open';
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        if ($status != 'all') {
            $builder->where('status', Order::getTypeValue($status));
        }
        
        $orders = $builder->get();//->sortByDesc('status');
        // dd($table->open_orders, $table->getStatus('name'));
        return view('cashier::tables.show', compact('table', 'orders', 'status', 'from_date', 'to_date'));
    }
}