<?php

namespace Modules\Restaurant\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Hall;

class HallController extends Controller
{
    /**
     * Check if user have permission in every request
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __construct()
    {
        $this->middleware('permission:halls-create')->only(['create', 'store']);
        $this->middleware('permission:halls-read')->only(['index', 'show']);
        $this->middleware('permission:halls-update')->only(['edit', 'update']);
        $this->middleware('permission:halls-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $halls = Hall::all();

        return  view('restaurant::halls.index', compact('halls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::has('employee')->get();

        return  view('restaurant::halls.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hall = Hall::create($request->except('manager_id'));

        // Check if store has manager & save it.
        if ($request->manager_id > 0)
            $hall->manager_id = $request->manager_id;

        $hall->save();

        return redirect()->route('halls.index')->with('success', __('global.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Hall $hall)
    {
        return  view('restaurant::halls.show', compact('hall'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function edit(Hall $hall)
    {
        $managers = User::has('employee')->get();

        return  view('restaurant::halls.edit', compact('hall', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall $hall)
    {
        $hall->update($request->except('manager_id'));

        // Check if store has manager & save it.
        if ($request->manager_id > 0)
            $hall->manager_id = $request->manager_id;

        $hall->save();

        return redirect()->route('halls.index')->with('success', __('global.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall $hall)
    {
        $hall->delete();

        return redirect()->route('halls.index')->with('success', __('global.delete_success'));
    }
}
