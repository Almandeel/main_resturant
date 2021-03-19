<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\{Account, Entry, Safe};
use App\{User, Role, Permission};
use Illuminate\Routing\Controller;
use Modules\Subscription\Models\Subscription;
use Modules\Restaurant\Models\{Waiter, Order, Delivery, Driver};

class CashiersController extends Controller
{
    
    public function __construct() {
        $this->middleware('permission:employees-create')->only(['create', 'store']);
        $this->middleware('permission:employees-read')->only(['index', 'show']);
        $this->middleware('permission:employees-update')->only(['edit', 'update']);
        $this->middleware('permission:employees-delete')->only('destroy');
    }
    /**
    * Display a listing of the resource.
    *  
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $cashiers = Employee::cashiers()->except([auth()->user()->employee->id]);
        return view('restaurant::cashiers.index', compact('cashiers'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $permissions = Permission::all();
        return view('restaurant::cashiers.create', compact('permissions'));
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:45',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'username' => 'required|string|max:100|min:3 |regex:/^[A-Za-z-0-9]+$/| unique:users',
            'password' => 'required|string|min:6',
        ];
        $request->validate($rules);
        
        $employee = Employee::create($request->only(['name', 'phone', 'address','salary']));
        
        $user_data['username'] = $request->username;
        $user_data['phone'] = $request->phone;
        $user_data['password'] = bcrypt($request->password);
        $user_data['employee_id'] = $employee->id;
        $user = User::create($user_data);

        if ($user && $request->type == "resturant") {
            $user->roles()->attach(Role::cashier()->id);
        }

        if ($user && $request->type == "market") {
            $user->roles()->attach(Role::market()->id);
        }

        if($user) {
            if ($request->permissions) $user->permissions()->attach($request->permissions);
        }

        
        session()->flash('success', 'تمت اضافة الموظف بنجاح');
        if ($request->next == 'list') {
            return redirect()->route('restaurant.cashiers.index');
        }
        elseif ($request->next == 'show') {
            return redirect()->route('restaurant.cashiers.show', $employee);
        }
        else{
            return back();
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request, Employee $cashier)
    {
        $user = $cashier->user;
        $account = $cashier->account;

        $opening_entry = $cashier->openingEntry();
        $close_entry = $cashier->closeEntry();

        if($request->has('date')) {
            $date = $request->date ;
        }elseif($opening_entry->count() > $close_entry->count()) {
            $date = $opening_entry->last()->created_at->format('Y-m-d H:i:s');
        }else {
            $date = date('Y-m-d H:i:s');
        }

        $to_date = date('Y-m-d H:i:s');

        $orders = Order::where('user_id', $user->id)
            ->whereBetween('created_at', [$date, $to_date])
            ->orderBy('created_at')
            ->paginate();

        $subscriptions = Subscription::where('user_id', $user->id)
            ->whereBetween('created_at', [$date, $to_date])
            ->orderBy('created_at')
            ->paginate();

        $all_orders = Order::where('user_id', $user->id)
        ->whereBetween('created_at', [$date, $to_date])
        ->get();

        $all_subscriptions = Subscription::where('user_id', $user->id)
        ->whereBetween('created_at', [$date, $to_date])
        ->get();




        // $type = $request->has('type') ? $request->type : 'all';
        // $status = $request->has('status') ? $request->status : 'all';
        // $status = $type == 'takeaway' && $status == 'open' ? 'closed' : $status;
        
        // $date_time = $date ;
        // $to_date_time = $to_date ;
        
        // $builder->whereBetween('created_at', [$date_time, $to_date_time]);

        // $builder_subscription->whereBetween('created_at', [$date_time, $to_date_time]);

        // if ($type != 'all') {
        //     $builder->where('type', Order::getTypeValue($type));
        // }
        
        // if ($status != 'all') {
        //     $builder->where('status', Order::getStatusValue($status));
        // }
        // $orders = $builder->get();
        //$orders = $orders->sortByDesc('status');

        // $subscriptions = $builder_subscription->get();
        $accounts = Account::where('group_id', 11)->where('id', '!=', $account->id)->get();
        $safes = Safe::all();
        $closing_amount = null;
        $deducation = null;

        if ($opening_entry->count() > $close_entry->count()) {
            $closing_amount = $all_orders->sum('amount') + $all_subscriptions->sum('amount');
            $closing_amount += $opening_entry ? $opening_entry->last()->amount : 0;
        }
        //  type   status
        return view('restaurant::cashiers.show', compact('all_subscriptions','all_orders', 'to_date', 'date','cashier', 'user', 'orders', 'safes', 'accounts', 'account', 'closing_amount', 'opening_entry', 'close_entry', 'subscriptions'));
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Employee  $cashier
    * @return \Illuminate\Http\Response
    */
    public function edit(Employee $cashier)
    {
        $user = $cashier->user;
        $permissions = Permission::all();
        $cashier_permissions = $cashier->permissions;
        $cashier_permissions = is_null($cashier_permissions) ? [] : $cashier->permissions->pluck('id')->toArray();
        return view('restaurant::cashiers.edit', compact('cashier', 'user', 'permissions', 'cashier_permissions'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Employee $cashier)
    {
        $user = $cashier->user;
        $request->validate([
        'name' => 'required|string|max:45',
        'phone' => 'required|string|max:30|unique:employees,phone,'.$cashier->id,
        'address' => 'required|string|max:255',
        'username' => 'required|string|max:100|min:3 |regex:/^[A-Za-z-0-9]+$/|unique:users,username,'.$user->id,
        'password' => 'string|min:6|nullable',
        ]);
        
        $cashier->update($request->only(['name', 'phone', 'address','salary']));
        
        $user_data['username'] = $request->username;
        
        if ($request->has('phone')) {
            $user_data['phone'] = $request->phone;
        }
        
        if (!empty($request->password)) {
            $user_data['password'] = bcrypt($request->password);
        }
        
        $user->update($user_data);
        if ($request->permissions) {
            $user->permissions()->detach();
            $user->permissions()->attach($request->permissions);
        }
        session()->flash('success', 'تمت العملية بنجاح');
        
        if ($request->next == 'list') {
            return redirect()->route('restaurant.cashiers.index');
        }
        elseif ($request->next == 'show') {
            return redirect()->route('restaurant.cashiers.show', $cashier);
        }
        else{
            return back();
        }
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
    public function destroy(Employee $cashier)
    {
        $cashier->delete();
        
        session()->flash('success', 'تمت العملية بنجاح');
        
        
        return redirect()->route('restaurant.cashiers.index');
    }
}