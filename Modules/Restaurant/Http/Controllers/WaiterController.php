<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Waiter;

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
        $waiters = Waiter::all();
        return view('restaurant::waiters.index', compact('waiters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant::waiters.create');
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
            'phone'     => 'required | string | min:10',
            'address'   => 'required | string',
            'salary'    => 'required | string',
        ]);

        $employee = Employee::create($request->only(['name', 'phone', 'address','salary']));

        $waiter = Waiter::create($request->except('salary'));

        session()->flash('success', 'restaurant::global.create_success');

        if ($request->next == 'back') {
            return back();
        } else {
            return redirect()->route('waiters.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function show(Waiter $waiter)
    {
        return view('restaurant::waiters.show', compact('waiter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        return view('restaurant::waiters.edit', compact('waiter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waiter $waiter)
    {
        request()->validate([
            'name'      => 'required | string | max:100 | min:3',
            'phone'     => 'required | string | min:10',
            'address'     => 'nullable | string',
        ]);

        $waiter->update($request->all());

        session()->flash('success', 'global.update_success');

        return redirect()->route('waiters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiter $waiter)
    {
        $waiter->delete();

        session()->flash('success', 'global.delete_success');

        return redirect()->route('waiters.index');
    }
}
