<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Menu;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:menus-create')->only(['create', 'store']);
        $this->middleware('permission:menus-read')->only(['index', 'show']);
        $this->middleware('permission:menus-update')->only(['edit', 'update']);
        $this->middleware('permission:menus-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('restaurant::menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return view('restaurant::menus.create', compact('items'));
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
            'items' => 'sometimes|array',
            'items.*.*' => 'sometimes|numeric|exists:items,id',
        ]);

        $menu = Menu::create($request->all());

        $menu->items()->attach($request->items);

        session()->flash('success', 'restaurant::global.create_success');

        if ($request->next == 'back') {
            return back();
        } else {
            return redirect()->route('menus.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return view('restaurant::menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $items = Item::all();
        return view('restaurant::menus.edit', compact('menu', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        request()->validate([
            'name'      => 'required | string | max:100 | min:3',
            'items' => 'sometimes|array',
            'items.*.*' => 'sometimes|numeric|exists:items,id',
        ]);

        $menu->update(['name' => $request->name]);

        $menu->items()->sync($request->items);

        session()->flash('success', 'global.update_success');

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->items()->sync([]);
        $menu->delete();

        session()->flash('success', 'global.delete_success');

        return redirect()->route('menus.index');
    }
}
