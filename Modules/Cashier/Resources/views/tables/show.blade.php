@extends('cashier::layouts.master', [
    'title' => 'الطاولات',
    'crumbs' => [
        ['url' => route('cashier.tables.index'), 'title' => 'الطاولات', 'icon' => 'fa fa-circle'],
        ['title' => 'طاولة: ' . $table->number, 'icon' => 'fa fa-circle'],
    ]
])
@push('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">طاولة: {{ $table->number }}</h3>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">الطلبات</h3>
            <div class="box-tools">
                <form action="" class="form-inline" style="display: inline-block;">
                    <div class="form-group">
                        <span>
                            <i class="fa fa-filter"></i>
                            <span>فرز</span><i class="fa fa-hand-o-left"></i> &nbsp;
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach (__('restaurant::orders.statuses') as $key => $value)
                                @if (!is_array($key))
                                    <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="from_date">من</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}"/>
                    </div>
                    <div class="form-group">
                        <label for="to_date">إلى</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body">
            <table id="tables-table" class="table table-bordered table-striped table-hover text-center datatable">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>الحالة</th>
                        <th>الكمية</th>
                        <th>القيمة</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->displayStatus() }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td>{{ number_format($order->amount, 2) }}</td>
                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                            <td>
                                @permission('orders-read')
                                    <a href="{{ route('cashier.orders.show', $order) }}" class="btn btn-info">
                                        <i class="fa fa-eye"></i>
                                        <span>عرض</span>
                                    </a>
                                @endpermission
                                @permission('orders-read')
                                    <a href="{{ route('cashier.orders.show', ['order' => $order, 'view' => 'print']) }}" class="btn btn-default">
                                        <i class="fa fa-print"></i>
                                        <span>طباعة</span>
                                    </a>
                                @endpermission
                                @if ($order->isOpen())
                                    @permission('orders-update')
                                        <form action="{{ route('cashier.orders.update', $order) }}" method="post" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ Modules\Restaurant\Models\Order::STATUS_CLOSED }}" />
                                            <button type="button" class="btn btn-success" data-toggle="confirm"
                                                data-title="إغلاق طلب" data-text="سوف يتم إغلاق الطلب استمرار؟" data-icon="success"
                                                >
                                                <i class="fa fa-check"></i>
                                                <span>إغلاق</span>
                                            </button>
                                        </form>
                                    @endpermission
                                    @permission('orders-update')
                                        <a href="{{ route('cashier.pos', ['order_id' => $order->id]) }}" class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                            <span>تعديل</span>
                                        </a>
                                    @endpermission
                                @endif
                                @if ($order->isOpen() || $order->isCanceled())
                                    @permission('orders-update')
                                        <form action="{{ route('cashier.orders.update', $order) }}" method="post" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ Modules\Restaurant\Models\Order::STATUS_CANCELED }}" />
                                            <button type="button" class="btn btn-danger" data-toggle="confirm"
                                                data-title="إلغاء طلب" data-text="سوف يتم إلغاء الطلب استمرار؟"
                                                >
                                                <i class="fa fa-times"></i>
                                                <span>إلغاء</span>
                                            </button>
                                        </form>
                                    @endpermission
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endpush
