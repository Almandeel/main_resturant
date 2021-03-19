<?php

namespace Modules\Subscription\Http\Controllers;

use App\Setting;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Modules\Subscription\Models\Plan;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscription\Models\Subscription;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:subscriptions-create')->only(['create','store']);
        $this->middleware('permission:subscriptions-read')->only(['index', 'show', 'dashboard']);
        $this->middleware('permission:subscriptions-update')->only(['edit', 'update']);
        $this->middleware('permission:subscriptions-delete')->only('destroy');
    }

    public function dashboard() {
        $subscriptions      = Subscription::get();
        $plans              = Plan::all();
        $customers          = Customer::whereNotIn('id', $subscriptions->where('customer_id', '!=',14)->pluck('customer_id')->toArray())->get();
        return view('subscription::dashboard', compact('subscriptions', 'plans', 'customers'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if(auth()->user()->id == 1) {
            $subscriptions      = Subscription::with('plan')
            ->when($request->barcode, function ($query, $request) {
                return $query->where('id', $request->barcode);
            })
            ->orderBy('created_at', 'desc')->paginate();
        }else {
            $subscriptions      = Subscription::with('plan')
            ->when($request->barcode, function ($query) use($request) {
                return $query->where('id', $request->barcode);
            })
            ->orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->whereDate('created_at', date("Y-m-d"))->paginate();
        }
        $plans              = Plan::all();
        $customers          = Customer::whereNotIn('id', $subscriptions->where('customer_id', '!=',14)->pluck('customer_id')->toArray())->get();
        return view('subscription::subscriptions.index', compact('subscriptions', 'plans', 'customers'));
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
        request()->validate([
            'customer_id'       => 'required',
            'plan_id'           => 'required',
            'payment_type'      => 'required',
        ]);

        $count = $request->count ?? 1;
        $subscriptions = [];

        $plan = Plan::find($request->plan_id);
        $request_date = $request->all();
        $request_date['start_date'] = Carbon::now('Africa/Khartoum');
        $request_date['end_date'] =  Carbon::now('Africa/Khartoum')->addDays($plan->period);
        $request_date['user_id'] =  auth()->user()->id;
        $request_date['amount'] =  $plan->amount;

        for ($i=0; $i < $count; $i++) { 
            $subscription = Subscription::create($request_date);
            array_push($subscriptions, $subscription->id);
        }

        $subscriptions = Subscription::whereIn('id', $subscriptions)->get();


        return view('subscription::subscriptions.barcode', compact('subscriptions'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $plans              = Plan::all();
        $customers          = Customer::get();
        $subscription       = Subscription::find($id);
        return view('subscription::subscriptions.show', compact('subscription', 'customers', 'plans'));
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
        $subscription = Subscription::find($id);
        request()->validate([
            'customer_id'       => 'required',
            'plan_id'           => 'required',
            'payment_type'      => 'required',
        ]);

        $plan = Plan::find($request->plan_id);

        $request_date = $request->all();
        $request_date['start_date'] = Carbon::now('Africa/Khartoum');
        $request_date['end_date'] = $request_date['start_date']->addDays($plan->period);

        if($request->type == 'resubscribe') {
            $new_subscription = Subscription::create($request_date);
            $subscription->delete();
        }else {
            $subscription->update($request_date);
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
        $subscription = Subscription::find($id);

        $subscription->update([
            'canceled_at' => date('Y-m-d')
        ]);

        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'تمت العملية بنجاح');
    }

    public function barcode($id) 
    {
        $subscriptions;
        if($id == "all")
        {
            $subscriptions = Subscription::all();
        }
        else 
        {
            $subscriptions = Subscription::where('id', $id)->get();
        }
        return view('subscription::subscriptions.barcode', compact('subscriptions'));
    }

    public function card($id) {
        $customer = Customer::find($id);
        $setting = Setting::first();
        return view('subscription::customers.card', compact('customer', 'setting'));
    }
}
