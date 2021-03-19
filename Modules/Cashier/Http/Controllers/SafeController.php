<?php
namespace Modules\Cashier\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Restaurant\Models\{Order, ItemOrder, Delivery};
class SafeController extends Controller
{
    public function index(Request $request)
    {
        $builder = Order::orderBy('updated_at');
        $from_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $to_date = $request->has('to_date') ? $request->to_date : date('Y-m-d');
        
        $type = $request->has('type') ? $request->type : 'local';
        $status = $request->has('status') ? $request->status : 'open';
        $status = $type == 'takeaway' && $status == 'open' ? 'closed' : $status;
        
        $from_date_time = $from_date . ' 00:00:00';
        $to_date_time = $to_date . ' 23:59:59';
        
        $builder->whereBetween('created_at', [$from_date_time, $to_date_time]);
        if ($type != 'all') {
            $builder->where('type', Order::getTypeValue($type));
        }
        
        if ($status != 'all') {
            $builder->where('status', Order::getStatusValue($status));
        }
        
        $orders = $builder->get();//->sortByDesc('status');
        // dd($orders->last()->delivery);
        return view('cashier::safes.index', compact('orders', 'type', 'status', 'from_date', 'to_date'));
    }
}