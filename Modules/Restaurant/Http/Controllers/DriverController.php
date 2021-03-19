<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Driver;

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
    public function index()
    {
        $drivers = Driver::all();
        return view('restaurant::drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant::drivers.create');
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
            'name'      => 'required | string | max:100 | min:3',
            'phone'     => 'required | string | min:10|regex:/^[0-9]+$/',
            'address'     => 'required | string',
            'salary'     => 'required | string',
        ]);

        $employee = Employee::create($request->only(['name', 'phone', 'address','salary']));

        $driver = Driver::create($request->except('salary'));

        session()->flash('success', 'restaurant::global.create_success');

        if ($request->next == 'back') {
            return back();
        } else {
            return redirect()->route('drivers.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        return view('restaurant::drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        return view('restaurant::drivers.edit', compact('driver'));
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
            'name'      => 'required | string | max:100 | min:3',
            'phone'     => 'required | string | min:10|regex:/^[0-9]+$/',
            'address'     => 'nullable | string',
        ]);

        $driver->update($request->all());

        session()->flash('success', 'global.update_success');

        return redirect()->route('drivers.index');
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

        return redirect()->route('drivers.index');
    }
}
