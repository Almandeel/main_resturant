<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscription\Models\Plan;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscription\Models\ModelHasPlan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $plans = Plan::all();
        return view('subscription::plans.index', compact('plans'));
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
        $request->validate([
            'name'      => 'required | unique:plans',
            'amount'    => 'required',
            'period'    => 'required',
        ]);

        $plan = Plan::create($request->all());


        if($request->subplans) {
            foreach ($request->subplans as  $subplan) {
                $sub = ModelHasPlan::create([
                    'plan_id' => $plan->id,
                    'subplan_id' => $subplan,
                ]);
            }
        }

        return back()->with('success', 'تمت العملية بنجاح');
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
        $plan = Plan::find($id);
        $plans = Plan::all();
        return view('subscription::plans.edit', compact('plan', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);

        $request->validate([
            'name'      => "required | unique:plans,name, {$plan->id}",
            'amount'    => 'required',
            'period'    => 'required',
        ]);

        $plan->update($request->all());

        $plan->subPlans()->delete();
        if($request->subplans) {
            foreach ($request->subplans as  $subplan) {
                $sub = ModelHasPlan::create([
                    'plan_id' => $plan->id,
                    'subplan_id' => $subplan,
                ]);
            }
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
