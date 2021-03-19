@extends('restaurant::layouts.master', [
    'title' => 'موظفو كاشير: ' . $cashier->name,
    'datatable' => true,
    'snippts' => true,
    'crumbs' => [
        ['url' => route('restaurant.cashiers.index'), 'title' => 'موظفو الكاشير', 'icon' => 'fa fa-users'],
        ['title' => $cashier->name, 'icon' => 'fa fa-user'],
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
            {{-- <div class="box-tools">
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
            </div> --}}
        </div>
        <div class="box-body">
                <h4>
                    <i class="icon-order"></i>
                    <span>الطلبات</span>
                </h4>
                <table id="orders-table" class="table table-bordered table-striped table-hover datatable text-center">
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
                        @foreach ($orders->where('is_market', 0) as $order)
                            <tr @if($order->discount > 0) style="background-color:#f39d2ff0; font-weight:bold"  @endif>
                                <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                <td>{{ $order->number }}</td>
                                <td>{{ $order->displayType() }}</td>
                                <td>{{ $order->displayStatus() }}</td>
                                <td class="order-quantity">{{ $order->items->count() }}</td>
                                <td class="order-total">{{ number_format($order->total, 2) }}</td>
                                <td class="order-discount">{{ number_format($order->discount, 2) }}</td>
                                <td class="order-net">{{ number_format($order->net, 2) }}</td>
                                <td style="background-color:#fff !important;">
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
                        <th class="">{{ $all_orders->sum('amount') }}</th>
                        <th class="">{{ $all_orders->sum('discount') }}</th>
                        <th class="">{{ number_format($all_orders->sum('amount') - $all_orders->sum('discount'), 2) }}</th>
                        <th colspan="1"></th>
                    </tfoot>
                </table>
                {{ $orders->links() }}

                <h4>
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
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->created_at->format('Y-m-d') }}</td>
                                <td>{{ $subscription->id }}</td>
                                <td>{{ $subscription->customer->name }}</td>
                                <td>{{ $subscription->plan->name }}</td>
                                <td class="subscriptions-total">{{ $subscription->amount }}</td>
                                <td>
                                    @permission('subscriptions-read')
                                        <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye">عرض</i></a>
                                    @endpermission
                                    @permission('subscriptions-print')
                                        <a href="{{ route('subscriptions.barcodes', $subscription->id) }}" class="btn btn-default btn-sm print" > <i class="fa fa-print"> طباعة </i></a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="4">إجمالي كل الاشتراكات</th>
                        <th class="">{{ $all_subscriptions->sum('amount') }}</th>
                    </tfoot>
                </table>
                {{ $subscriptions->links() }}
                <h4>
                    <i class="icon-order"></i>
                    <span>المبيعات</span>
                </h4>
                <table id="pos-table" class="table table-bordered table-striped table-hover datatable text-center">
                    <thead>
                        <tr>
                            <th>تاريخ الإنشاء</th>
                            <th>الكمية</th>
                            <th>الاجمالي</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders->where('is_market', 1) as $order)
                            <tr>
                                <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                <td class="pos-quantity">{{ $order->items->count() }}</td>
                                <td class="pos-total">{{ number_format($order->total, 2) }}</td>
                                <td style="background-color:#fff !important;">
                                    @permission('orders-read')
                                        <a href="{{url('/market/pos/print' . '/' . $order->id) }}" class="btn btn-info">
                                            <i class="fa fa-eye"></i>
                                            <span>عرض</span>
                                        </a>
                                    @endpermission
                                    @permission('orders-read')
                                        <a href="{{ url('/market/pos/print' . '/' . $order->id . '?view=print') }}" class="btn btn-default">
                                            <i class="fa fa-print"></i>
                                            <span>طباعة</span>
                                        </a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="1">إجمالي كل المبيعات</th>
                        <th class="total-pos-quantity">0</th>
                        <th class="total-pos-total">0.00</th>
                        <th colspan="1"></th>
                    </tfoot>
                </table>
        </div>
        <div class="box-footer">
            <h4>
                <i class="fa fa-list"></i>
                <span>القيود</span>
            </h4>
            <table id="entries-create-table" class="table table-bordered table-striped table-hover">
                <tbody>
                    @if ($opening_entry->count() == $close_entry->count())
                        <tr class="print-hide">
                            <td>قيد إفتتاحي</td>
                            <td><select name="to_id" class="form-control">
                                @foreach ($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select></td>
                            <td><input type="number" name="amount" class="form-control"></td>
                            <td>
                                <div class="input-group">
                                    <textarea name="details" class="form-control"></textarea>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-create-opening-entry">
                                            <i class="fa fa-plus"></i>
                                            <span>إنشاء</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                    {{-- 
                        && !$close_entry
                        && $opening_entry
                    --}}
                    @if ($opening_entry->count() >= $close_entry->count())
                        <tr class="print-hide">
                            <td>قيد الإغلاق</td>
                            <td><select name="from_id" class="form-control">
                                @foreach ($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">المدفوع</span>
                                    <input type="number" name="amount" class="form-control" value="{{ $closing_amount }}">
                                {{-- </div>
                                <div class="input-group"> --}}
                                    <span class="input-group-addon">الخصم</span>
                                    <input type="number" name="deducation" class="form-control" value="0">
                                {{-- </div>
                                <div class="input-group"> --}}
                                    <span class="input-group-addon">الخزنة</span>
                                    <select name="safe_id" class="form-control">
                                        @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <textarea name="details" class="form-control"></textarea>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-create-close-entry">
                                            <i class="fa fa-plus"></i>
                                            <span>إنشاء</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- <table id="entries-table" class="table table-bordered table-striped table-hover datatable">
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
            </table> --}}
        </div>
    </div>
    <form id="create-entry-from" action="{{ route('entries.store') }}" method="post">
        @csrf
        <input type="hidden" name="from_id">
        <input type="hidden" name="to_id">
        <input type="hidden" name="amount">
        <input type="hidden" name="details">
        <input type="hidden" name="type">
        <input type="hidden" name="created_at" value="{{ $date }}">
        <input type="hidden" name="deducation">
        <input type="hidden" name="safe_id">
    </form>
@endpush
@push('foot')
    <script>
        $(function(){
            $(document).on('change, keyup', 'input[name=deducation]', function(){
                let row = $(this).closest('tr')
                let field_amount = row.find('input[name=amount]')
                let value = $(this).val();
                if(value > 0){
                    let amount = Number({{ $closing_amount }}) - value;
                    field_amount.val(amount)
                }else{
                    field_amount.val({{ $closing_amount }})
                }
            })
            $('.btn-create-opening-entry').click(function(){
                let form = $('#create-entry-from')
                let field_from_id = $('#create-entry-from input[name=from_id]')
                let field_to_id = $('#create-entry-from input[name=to_id]')
                let field_amount = $('#create-entry-from input[name=amount]')
                let field_details = $('#create-entry-from input[name=details]')
                let field_type = $('#create-entry-from input[name=type]')

                let row = $(this).closest('tr')
                let to_id = row.find('select[name=to_id]').val()
                let amount = row.find('input[name=amount]').val()
                let details = row.find('textarea[name=details]').val()
                // let type;
                if(!amount){
                    sweet('خطأ', 'لا يمكنك ترك حقل القيمة فارغ', 'error')
                    row.find('input[name=amount]').focus()
                }else{
                    field_from_id.val({{ $account->id }})
                    field_to_id.val(to_id)
                    field_amount.val(amount)
                    field_details.val(details)
                    // field_type.val(type)
                    form.submit()
                }
            })
            $('.btn-create-close-entry').click(function(){
                let form = $('#create-entry-from')
                let field_from_id = $('#create-entry-from input[name=from_id]')
                let field_to_id = $('#create-entry-from input[name=to_id]')
                let field_amount = $('#create-entry-from input[name=amount]')
                let field_deducation = $('#create-entry-from input[name=deducation]')
                let field_safe_id = $('#create-entry-from input[name=safe_id]')
                let field_details = $('#create-entry-from input[name=details]')

                let row = $(this).closest('tr')
                let from_id = row.find('select[name=from_id]').val()
                let amount = row.find('input[name=amount]').val()
                let deducation = row.find('input[name=deducation]').val()
                let safe_id = row.find('select[name=safe_id]').val()
                let details = row.find('textarea[name=details]').val()
                // let type;
                if(!amount){
                    sweet('خطأ', 'لا يمكنك ترك حقل القيمة فارغ', 'error')
                    row.find('input[name=amount]').focus()
                }
                else if(deducation > 0 && !safe_id){
                    sweet('خطأ', 'لا يمكنك ترك حقل الخزنة فارغ', 'error')
                    row.find('select[name=safe_id]').focus()
                }
                else{
                    field_to_id.val({{ $account->id }})
                    field_from_id.val(from_id)
                    field_amount.val(amount)
                    field_deducation.val(deducation)
                    field_safe_id.val(safe_id)
                    field_details.val(details)
                    // field_type.val(type)
                    form.submit()
                }
            })
            /*
            $('#orders-table').dataTable({
                paging: false,
                dom: 'Bfrtip',
                buttons:[
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i><span>اكسل</span>',
                        classes: 'btn btn-success'
                    }
                ]
            });
            */

            calculateTotals()
        })
        function calculateTotals(){
            let orders_quantities = $('.order-quantity');
            let orders_totals = $('.order-total');
            let orders_discounts = $('.order-discount');
            let orders_nets = $('.order-net');
            let subscriptions_total = $('.subscriptions-total');
            let pos_quantities = $('.pos-quantity');
            let pos_total = $('.pos-total');

            let total_quantities = 0;
            let total_totals = 0;
            let total_discounts = 0;
            let total_nets = 0;
            let subscriptions_net = 0;



            let pos_net = 0;
            let total_pos_quantities = 0;

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

            for (let index = 0; index < subscriptions_total.length; index++) {
                subscriptions_net += fillterNumber($(subscriptions_total[index]).text());
            }


            for (let index = 0; index < pos_total.length; index++) {
                pos_net += fillterNumber($(pos_total[index]).text());
                let pos_quantity = fillterNumber($(pos_quantities[index]).text());

                total_pos_quantities += pos_quantity

            }

            $('.total-quantity').text(total_quantities);
            $('.total-total').text(number_format(total_totals, 2));
            $('.total-discount').text(number_format(total_discounts, 2));
            $('.total-net').text(number_format(total_nets, 2));
            $('.subscriptions-net').text(number_format(subscriptions_net, 2));
            $('.total-pos-total').text(number_format(pos_net, 2));
            $('.total-pos-quantity').text(total_pos_quantities);

        }
    </script>
@endpush