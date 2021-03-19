@extends('cashier::layouts.master', [
    'title' => config('cashier.name') . ' | الخزنة',
    'datatable' => true,
    'snippts' => true,
    'crumbs' => [
        ['title' => 'الخزنة', 'icon' => 'fa fa-money'],
    ]
])
@push('content')
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>المعرف</th>
                        <th>الاسم</th>
                        <th>اسم الدخول</th>
                        <th>المرتب</th>
                        <th>رقم الهاتف</th>
                        <th>العنوان</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $cashier->id }}</td>
                        <td>{{ $cashier->name }}</td>
                        <td>{{ $cashier->username }}</td>
                        <td>{{ $cashier->salary != null ? number_format($cashier->salary) : 0 }}</td>
                        <td>{{ $cashier->phone }}</td>
                        <td>{{ $cashier->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer text-center">
            <div class="btn-group"></div>
            @permission('employees-delete')
            <form action="{{ route('restaurant.cashiers.destroy', $cashier) }}" method="POST" style="display: inline">
                @csrf
                {{ method_field('DELETE') }}
                <button type="button" data-toggle="confirm" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> حذف </button>
            </form>
            @endpermission
            @permission('entries-create')
            @endpermission
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">
                <i class="icon-order"></i>
                <span>الخزنة</span>
            </h3>
            <div class="box-tools">
                <form action="" class="form-inline" style="display: inline-block;">
                    <div class="form-group">
                        <label for="date">التاريخ</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}"/>
                    </div>
                    <div class="form-group">
                        <span>
                            <i class="fa fa-filter"></i>
                            <span>فرز الطلبات</span><i class="fa fa-hand-o-left"></i> &nbsp;
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="type">النوع</label>
                        <select name="type" id="type" class="form-control">
                            <option value="all" {{ $type == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach (__('restaurant::orders.types') as $key => $value)
                            <option value="{{ $key }}" {{ $type == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body">
            <h4>
                <i class="icon-order"></i>
                <span>الطلبات</span>
            </h4>
            <table id="orders-table" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <th>رقم الطلب</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <th>الكمية</th>
                        <th>الاجمالي</th>
                        <th>الخصم</th>
                        <th>الصافي</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->displayType() }}</td>
                            <td>{{ $order->displayStatus() }}</td>
                            <td class="order-quantity">{{ $order->items->count() }}</td>
                            <td class="order-total">{{ number_format($order->total, 2) }}</td>
                            <td class="order-discount">{{ number_format($order->discount, 2) }}</td>
                            <td class="order-net">{{ number_format($order->net, 2) }}</td>
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
                                @if ($order->isOpen())
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
                <tfoot>
                    <th colspan="4">إجمالي كل الطلبات</th>
                    <th class="total-quantity">0</th>
                    <th class="total-total">0.00</th>
                    <th class="total-discount">0.00</th>
                    <th class="total-net">0.00</th>
                    <th colspan="2"></th>
                </tfoot>
            </table>

            <h4 style="margin-top:3%">
                <i class="icon-order"></i>
                <span>الاشتراكات</span>
            </h4>
            <table id="subscription-table" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <th>رقم الاشتراك</th>
                        <th>العميل</th>
                        <th>الباقة</th>
                        <th>المبلغ</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $total = 0;
                    @endphp
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->created_at->format('Y-m-d') }}</td>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->customer->name }}</td>
                            <td>{{ $subscription->plan->name }}</td>
                            <td class="subscriptions-total">{{ number_format($subscription->amount, 2) }}</td>
                            <td>
                                @permission('subscriptions-read')
                                    <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye">عرض</i></a>
                                @endpermission
                                @permission('subscriptions-print')
                                    <a href="{{ route('subscriptions.barcodes', $subscription->id) }}" class="btn btn-default btn-sm print" > <i class="fa fa-print"> طباعة </i></a>
                                @endpermission
                            </td>
                        </tr>
                        @php 
                            $total += $subscription->amount;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="4">إجمالي كل الاشتراكات</th>
                    <th class="subscriptions-net">{{ number_format($total, 2) }}</th>
                </tfoot>
            </table>
        </div>
        <div class="box-footer">
            <h4>
                <i class="fa fa-list"></i>
                <span>القيود</span>
            </h4>
            <table id="entries-table" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>النوع</th>
                        <th>الرقم</th>
                        <th>الحساب</th>
                        <th>القيمة</th>
                        <th>البيان</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($opening_entry)
                        <tr>
                            <td>قيد إفتتاحي</td>
                            <td>{{ $opening_entry->id }}</td>
                            <td>{{ $opening_entry->to->name }}</td>
                            <td>{{ number_format($opening_entry->amount, 2) }}</td>
                            <td>{{ $opening_entry->details }}</td>
                        </tr>
                    @endif
                    @if ($close_entry)
                        <tr>
                            <td>قيد إغلاق</td>
                            <td>{{ $close_entry->id }}</td>
                            <td>{{ $close_entry->to->name }}</td>
                            <td>{{ number_format($close_entry->amount, 2) }}</td>
                            <td>{{ $close_entry->details }}</td>
                        </tr>
                    @endif
                    @if ($deducation)
                        <tr>
                            <td>خصم</td>
                            <td>{{ $deducation->id }}</td>
                            <td>...</td>
                            <td>{{ number_format($deducation->amount, 2) }}</td>
                            <td>{{ $deducation->details }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endpush
@push('foot')
    <script>
        $(function(){
            calculateTotals();
            $('#entries-table').dataTable()
        })
        function calculateTotals(){
            let orders_quantities = $('.order-quantity');
            let orders_totals = $('.order-total');
            let orders_discounts = $('.order-discount');
            let orders_nets = $('.order-net');
            let total_quantities = 0;
            let total_totals = 0;
            let total_discounts = 0;
            let total_nets = 0;
            for(let index = 0; index < orders_quantities.length; index++){
                let quantity = fillterNumber($(orders_quantities[index]).text());
                let total = fillterNumber($(orders_totals[index]).text());
                let discounts = fillterNumber($(orders_discounts[index]).text());
                let nets = fillterNumber($(orders_nets[index]).text());

                total_quantities += quantity;
                total_totals += total;
                total_discounts += discounts;
                total_nets += nets;

            }

            $('.total-quantity').text(total_quantities);
            $('.total-total').text(number_format(total_totals, 2));
            $('.total-discount').text(number_format(total_discounts, 2));
            $('.total-net').text(number_format(total_nets, 2));
        }
    </script>
@endpush