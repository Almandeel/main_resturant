<?php

namespace Modules\Restaurant\Http\Controllers;

use App\User;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Hall;
use Modules\Restaurant\Models\Table;

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
        $this->middleware('permission:tables-create')->only(['create', 'store']);
        $this->middleware('permission:tables-read')->only(['index', 'show']);
        $this->middleware('permission:tables-update')->only(['edit', 'update']);
        $this->middleware('permission:tables-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::all();
        return  view('restaurant::tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $captins = User::has('employee')->get();
        $halls = Hall::all(); //has('groups')->get();
        $groups = Group::all();

        return  view('restaurant::tables.create', compact('captins', 'halls', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = Table::create($request->except('hall_id', 'captin_id'));

        // Check if store has hall & save it.
        if ($request->hall_id > 0)
            $table->hall_id = $request->hall_id;

        // Check if store has captin (waiter) & save it.
        if ($request->captin_id > 0)
            $table->captin_id = $request->captin_id;

        $table->save();

        return redirect()->route('tables.index')->with('success', __('global.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        $captins = User::all();
        $halls = Hall::all();
        $groups = Group::all();

        return  view('restaurant::tables.show', compact('table', 'captins', 'halls', 'groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        $captins = User::all();
        $halls   = Hall::all();
        $groups  = Group::all();

        return  view('restaurant::tables.edit', compact('table', 'captins', 'halls', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', __('global.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')->with('success', __('global.delete_success'));
    }
}
