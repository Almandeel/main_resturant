<?php

namespace Modules\Subscription\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $settings = Setting::whereModule('subscriptions')->get();
        return view('subscription::settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('subscription::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subscription::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('subscription::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);

        $setting->update($request->all());

        if($request->image) {
            if(file_exists(public_path('dashboard/img/' . $setting->value))) {
                unlink(public_path('dashboard/img/' . $setting->value));
            }
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('dashboard/img'), $fileName);
            $image = $fileName;

            $setting->update([
                'value' => $image
            ]);
        }

        return back()->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
