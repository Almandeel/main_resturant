<?php

namespace Modules\Cashier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\{Driver, Order};

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:drivers-create')->only(['create', 'store']);
        $this->middleware('permission:drivers-read')->only(['index', 'show']);
        $this->middleware('permission:drivers-update')->only(['edit', 'update']);
        $this->middleware('permission:drivers-delete')->only('destroy');
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $drivers = Driver::all();
        $titles = [
        'all' => 'الكل',
        'available' => 'المتوفرين',
        'busy' => 'المشغولين',
        'unavailable' => 'الغير متوفرين',
        ];
        $status = $request->has('status') ? $request->status : 'available';
        if ($status != 'all') {
            $drivers = $drivers->filter(function($driver) use ($status){
                return $driver->getStatus('name') == $status;
            });
        }
        $title = $titles[$status];
        return view('cashier::drivers.index', compact('drivers', 'title'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('cashier::drivers.create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        request()->validate([
        'name'      => 'required | string | max:100 | min:3|regex:/^[\sA-Za-z]+$/',
        'phone'     => 'required | string | min:10|regex:/^[0-9]+$/',
        'address'     => 'nullable | string|regex:/^[.\sA-Za-z0-9]+$/',
        ]);
        
        $driver = Driver::create($request->all());
        
        session()->flash('success', 'cashier::global.create_success');
        
        if ($request->next == 'back') {
            return back();
        } else {
            return redirect()->route('cashier.drivers.index');
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Driver  $driver
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request, Driver $driver)
    {
        $builder = $driver->orders->sortByDesc('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $status = $request->has('status') ? $request->status : 'open';
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder = $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        
        if ($status != 'all') {
            $builder = $builder->where('status', Order::getStatusValue($status));
        }
        
        $orders = $builder;//->sortByDesc('type')->sortByDesc('status');
        return view('cashier::drivers.show', compact('driver', 'orders', 'status', 'from_date', 'to_date'));
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Driver  $driver
    * @return \Illuminate\Http\Response
    */
    public function edit(Driver $driver)
    {
        return view('cashier::drivers.edit', compact('driver'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Driver  $driver
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Driver $driver)
    {
        request()->validate([
        'name'      => 'nullable | string | max:100 | min:3|regex:/^[\sA-Za-z]+$/',
        'phone'     => 'nullable | string | min:10|regex:/^[0-9]+$/',
        'address'     => 'nullable | string|regex:/^[.\sA-Za-z0-9]+$/',
        ]);
        $data = $request->except(['_token', '_method']);
        $driver->update($data);
        
        session()->flash('success', 'global.update_success');
        return back();
        return redirect()->route('cashier.drivers.index');
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Driver  $driver
    * @return \Illuminate\Http\Response
    */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        
        session()->flash('success', 'global.delete_success');
        
        return redirect()->route('cashier.drivers.index');
    }
}