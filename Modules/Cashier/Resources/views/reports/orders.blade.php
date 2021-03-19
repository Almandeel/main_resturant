@extends('cashier::layouts.master', [
    'title' => $title,
    // 'datatable' => true,
    'snippts' => true,
    'printable' => true,
    'tabletojson' => true,
    'crumbs' => [
        ['url' => route('cashier.reports.index'), 'title' => 'التقارير', 'icon' => 'fa fa-print'],
        ['title' => $title, 'icon' => $icon],
    ]
])
@push('head')
    {{--  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>  --}}
    {{--  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/datatables.min.css') }}">
    <script type="text/javascript" src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/buttons.print.js') }}"></script>
    <style type="text/css">
        .data-table-container {
            padding: 10px;
        }
    
        .dt-buttons .btn {
            margin-left: 3px;
        }

        .dataTables_filter{
            float: right !important;
            margin-bottom: 15px;
        }

        .dt-buttons{
            float: left !important;
            margin-bottom: 15px;
        }
    </style>
    <style media="all">
        .total{
            text-decoration: underline;
        }
    </style>
    <script>
        $(document).ready(function(){
            $.extend( true, $.fn.dataTable.defaults, {
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true,
                'oLanguage'    : {
                    "sEmptyTable":  "@lang('table.sEmptyTable')",
                    "sInfo":    "@lang('table.sInfo')",
                    "sInfoEmpty":   "@lang('table.sInfoEmpty')",
                    "sInfoFiltered":    "@lang('table.sInfoFiltered')",
                    "sInfoPostFix": "@lang('table.sInfoPostFix')",
                    "sInfoThousands":   "@lang('table.sInfoThousands')",
                    "sLengthMenu":  "@lang('table.sLengthMenu')",
                    "sLoadingRecords":  "@lang('table.sLoadingRecords')",
                    "sProcessing":  "@lang('table.sProcessing')",
                    "sSearch":  "@lang('table.sSearch')",
                    "sZeroRecords": "@lang('table.sZeroRecords')",
                    "oPaginate": {
                        "sFirst":   "@lang('table.sFirst')",
                        "sLast":    "@lang('table.sLast')",
                        "sNext":    "@lang('table.sNext')",
                        "sPrevious":    "@lang('table.sPrevious')"
                    },
                    "oAria": {
                        "sSortAscending":   "@lang('table.sSortAscending')",
                        "sSortDescending":  "@lang('table.sSortDescending')"
                    }
                },
                'dom': 'Bfrtip',
                "autoWidth": true,
                "columnDefs": [{
                    "visible": true,
                    "targets": -1
                }],
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i><span>طباعة المحتوى</span>',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i><span>تصدير Excel</span>',
                        classes: 'btn btn-success'
                    }
                ]
            } );
        $('table.data-table').dataTable({
            paging: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    autoPrint: true,
                    text: '<i class="fa fa-print"></i><span>طباعة</span>',
                    footer: true,
                    customize: function ( doc ) {
                        $(doc.document.body).find('h1').css({
                            'text-align': 'center', 'font-size': '15pt',
                            'font-weight': 'bold', 'margin-bottom': '30px',

                        });
                    },
                    //For repeating heading.
                    /*
                    title: '',
                    repeatingHead: {
                        logo: '',
                        logoPosition: 'right',
                        logoStyle: '',
                        title: '<h3>{{ $title }}</h3>'
                    }
                    */
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i><span>اكسل</span>',
                    classes: 'btn btn-success'
                },
                /*{
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i><span>تصدير PDF</span>',
                },*/
            ]

            /*columnDefs: [{
                targets: 'no-sort',
                orderable: false
            }],
            dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
                '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
                '<"row"<"col-sm-5"i><"col-sm-7"p>>',
            fixedHeader: {
                header: true
            },
            buttons: {
                buttons: [{
                    header: '<h1>التقارير</h1>',
                    extend: 'print',
                    text: '<i class="fa fa-print" style="display: none;"></i> طباعة',
                    title: $('h1').text(),
                    {{--  exportOptions: {
                    columns: ':not(.no-print)'
                    },
                    footer: true,
                    autoPrint: true  --}}
                }],
                dom: {
                    container: {
                        className: 'dt-buttons'
                    },
                    button: {
                        className: 'btn btn-default'
                    }
                }
            }*/
        });
        
        /* custom button event print */
        $(document).on('click', '#btn-print', function(){
           $(".buttons-print")[0].click(); //trigger the click event
        });
    
      });
    </script>
@endpush
@push('content')
    @if ($type == 'local')
        <div class="box box-primary">
            {{--  <div class="box-header">
                <h3 class="box-title">
                    الطلبات
                </h3>
            </div>  --}}
            <div class="box-extra">
                <form action="" class="form-inline" style="display: inline-block;">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="form-group">
                        <label>
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                            {{--  <i class="fa fa-hand-o-left"></i>  --}}
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="user_id">الكاشير</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="all" {{ $user_id == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="waiter_id">الكباتن</label>
                        <select id="waiter_id" name="waiter_id" class="form-control">
                            <option value="all" {{ $waiter_id == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($waiters as $waiter)
                            <option value="{{ $waiter->id }}" {{ $waiter_id == $waiter->id ? 'selected' : '' }}>{{ $waiter->name }}</option>
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
                        <label for="from_date">من</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}" />
                    </div>
                    <div class="form-group">
                        <label for="to_date">إلى</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                    {{--  <div class="form-group">
                        <button id="btn-print" type="button" class="btn btn-default">
                            <i class="fa fa-print"></i>
                            <span>طباعة</span>
                        </button>
                    </div>  --}}
                </form>
            </div>
            <div id="printable" class="box-body">
                <table id="orders-table" class="table table-bordered table-striped table-hover text-center data-table">
                    <thead>
                        <tr>
                            <th>الكاشير</th>
                            <th>الكابتن</th>
                            <th>الصالة</th>
                            <th>الطاولة</th>
                            <th>رقم الطلب</th>
                            <th>الحالة</th>
                            <th>الكمية</th>
                            <th>القيمة</th>
                            <th>الخصم</th>
                            <th>الصافي</th>
                            <th>تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ is_null($order->user) ? '' : $order->user->username }}</td>
                            <td>{{ is_null($order->waiter) ? '' : $order->waiter->name }}</td>
                            <td>{{ is_null($order->hall) ? '' : $order->hall->name }}</td>
                            <td>{{ is_null($order->orderTable) ? '' : $order->orderTable->number }}</td>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->displayStatus() }}</td>
                            <td class="order-quantity">{{ $order->items->count() }}</td>
                            <td class="order-amount">{{ number_format($order->amount, 2) }}</td>
                            <td class="order-discount">{{ number_format($order->discount, 2) }}</td>
                            <td class="order-net">{{ number_format($order->net, 2) }}</td>
                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="total total-quantity">0</th>
                        <th class="total total-amount">0.00</th>
                        <th class="total total-discount">0.00</th>
                        <th class="total total-net">0.00</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @elseif ($type == 'takeaway')
        <div class="box box-primary">
            <div class="box-extra">
                <form action="" class="form-inline" style="display: inline-block;">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="form-group">
                        <label>
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                            {{--  <i class="fa fa-hand-o-left"></i>  --}}
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="user_id">الكاشير</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="all" {{ $user_id == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
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
                        <label for="from_date">من</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}" />
                    </div>
                    <div class="form-group">
                        <label for="to_date">إلى</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                </form>
            </div>
            <div id="printable" class="box-body">
                <table id="orders-table" class="table table-bordered table-striped table-hover text-center data-table">
                    <thead>
                        <tr>
                            <th>الكاشير</th>
                            <th>رقم الطلب</th>
                            <th>الحالة</th>
                            <th>الكمية</th>
                            <th>القيمة</th>
                            <th>الخصم</th>
                            <th>الصافي</th>
                            <th>تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ is_null($order->user) ? '' : $order->user->username }}</td>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->displayStatus() }}</td>
                            <td class="order-quantity">{{ $order->items->count() }}</td>
                            <td class="order-amount">{{ number_format($order->amount, 2) }}</td>
                            <td class="order-discount">{{ number_format($order->discount, 2) }}</td>
                            <td class="order-net">{{ number_format($order->net, 2) }}</td>
                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="total total-quantity">0</th>
                        <th class="total total-amount">0.00</th>
                        <th class="total total-discount">0.00</th>
                        <th class="total total-net">0.00</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @elseif ($type == 'delivery')
        <div class="box box-primary">
            {{--  <div class="box-header">
                <h3 class="box-title">
                    الطلبات
                </h3>
            </div>  --}}
            <div class="box-extra">
                <form action="" class="form-inline" style="display: inline-block;">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="form-group">
                        <label>
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                            {{--  <i class="fa fa-hand-o-left"></i>  --}}
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="user_id">الكاشير</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="all" {{ $user_id == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="driver_id">السائقين</label>
                        <select id="driver_id" name="driver_id" class="form-control">
                            <option value="all" {{ $driver_id == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ $driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
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
                        <label for="from_date">من</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}" />
                    </div>
                    <div class="form-group">
                        <label for="to_date">إلى</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                    {{--  <div class="form-group">
                        <button id="btn-print" type="button" class="btn btn-default">
                            <i class="fa fa-print"></i>
                            <span>طباعة</span>
                        </button>
                    </div>  --}}
                </form>
            </div>
            <div id="printable" class="box-body">
                <table id="orders-table" class="table table-bordered table-striped table-hover text-center data-table">
                    <thead>
                        <tr>
                            <th>الكاشير</th>
                            <th>السائق</th>
                            <th>رقم الطلب</th>
                            <th>الحالة</th>
                            <th>الكمية</th>
                            <th>القيمة</th>
                            <th>الخصم</th>
                            <th>الصافي</th>
                            <th>تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ is_null($order->user) ? '' : $order->user->username }}</td>
                            <td>{{ is_null($order->driver) ? '' : $order->driver->name }}</td>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->displayStatus() }}</td>
                            <td class="order-quantity">{{ $order->items->count() }}</td>
                            <td class="order-amount">{{ number_format($order->amount, 2) }}</td>
                            <td class="order-discount">{{ number_format($order->discount, 2) }}</td>
                            <td class="order-net">{{ number_format($order->net, 2) }}</td>
                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="total total-quantity">0</th>
                        <th class="total total-amount">0.00</th>
                        <th class="total total-discount">0.00</th>
                        <th class="total total-net">0.00</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif
@endpush
@push('foot')
    <script>
        $(function(){
            calculateTotals();
            {{--  $('#btn-print').click(function(){
                var table = $('#printable table').tableToJSON({
                    headings: ['cashier', 'waiter', 'hall', 'table', 'orderId', 'status', 'quantity', 'amount', 'discount', 'net', 'createDate'],
                });
                printJS({
                    printable: table,
                    type: 'json',
                    css: "{{ asset('dashboard/css/bootstrap.min.css') }}",
                    properties: [
                        'cashier', // {field: 'cashier', displayName: 'الكاشير'}, 
                        'waiter', // {field: 'waiter', displayName: 'الكابتن'}, 
                        'hall', // {field: 'hall', displayName: 'الصالة'}, 
                        'table', // {field: 'table', displayName: 'الطاولة'}, 
                        'orderId', // {field: 'orderId', displayName: 'رقم الطلب'}, 
                        'status', // {field: 'status', displayName: 'الحالة'}, 
                        'quantity', // {field: 'quantity', displayName: 'الكمية'}, 
                        'amount', // {field: 'amount', displayName: 'القيمة'}, 
                        'discount', // {field: 'discount', displayName: 'الخصم'}, 
                        'net', // {field: 'net', displayName: 'الصافي'}, 
                        'createDate' // {field: 'createDate', displayName: 'التاريخ'}
                    ],
                    header: '<h3 class="header">{{ $title }}</h3>',
                    gridHeaderStyle: 'color: black; border: 1px solid #000000; text-align: right; display: none;',
                    gridStyle: 'padding: 10px; border: 1px solid #000000;',
                    style: '.header { color: black; } table, .header{direction: rtl; text-align: right;}'
                })
            })  --}}
            {{--  $('#orders-table').dataTable({
                paging: false,
                'dom': 'Bfrtip',
                fixedHeader: {
                    header: true
                },
                buttons: {
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i> Print',
                            title: $('h1').text(),
                            exportOptions: {
                                columns: ':not(.no-print)'
                            },
                            footer: true,
                            autoPrint: true
                        }, 
                    ],
                    dom: {
                    container: {
                        className: 'dt-buttons'
                    },
                    button: {
                        className: 'btn btn-default'
                    }
                    }
                }
            })  --}}
        })
        function calculateTotals(){
            let orders_quantities = $('.order-quantity');
            let orders_amounts = $('.order-amount');
            let orders_discounts = $('.order-discount');
            let orders_nets = $('.order-net');
            let total_quantities = 0;
            let total_amounts = 0;
            let total_discounts = 0;
            let total_nets = 0;
            for(let index = 0; index < orders_quantities.length; index++){
                let quantity = fillterNumber($(orders_quantities[index]).text());
                let amount = fillterNumber($(orders_amounts[index]).text());
                let discounts = fillterNumber($(orders_discounts[index]).text());
                let nets = fillterNumber($(orders_nets[index]).text());

                total_quantities += quantity;
                total_amounts += amount;
                total_discounts += discounts;
                total_nets += nets;

            }

            $('.total-quantity').text(total_quantities);
            $('.total-amount').text(number_format(total_amounts, 2));
            $('.total-discount').text(number_format(total_discounts, 2));
            $('.total-net').text(number_format(total_nets, 2));
        }
    </script>
@endpush