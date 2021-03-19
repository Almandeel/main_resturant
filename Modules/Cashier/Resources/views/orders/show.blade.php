@extends('layouts.dashboard.base', [
    'title' => 'طلب رقم #' . $order->number,
])
@push('head')
    <style>
        .order{
            width: 500px;
            margin: 30px auto;
            border: 1px solid #eeeeee;
            padding: 30px;
        }
        .order-header{
            padding-bottom: 15px;
            /*margin-bottom: 30px;*/
        }
        .order-body{
            /*margin-bottom: 30px;*/
        }
        .order-footer{
            border-bottom: 1px dotted;
            padding-bottom: 30px;
        }
        .double-line, .line{
            margin: 15pt 0;
        }
        .double-line{
            border-bottom-width: 4px;
            border-bottom-style: double;
        }
        .line{
            border-bottom: 1px dashed;
        }
        .order-footer strong{
            text-decoration: underline;
        }
        .order-footer p{
            text-align-last: left;
        }
        .order-footer table{
        }
        .order-footer table th, .order-footer table td{
            border: none !important;
            padding: 0 !important;
        }
        .order-buttons{
            padding: 15px;
            text-align: center;
        }
        .order{
            box-shadow: 2px 2px #eee, 4px 4px #ddd, 6px 6px #ccc, 8px 8px #bbb, 10px 10px #aaa, 0px 0px 20px 2px rgb(153 153 153 / 0.4);
        }
        @media print{
            .order{
                margin: 0;
                border: none;
                width: 100%;
                box-shadow: none;
            }
            .order-buttons{
                display: none;
            }
            .table>thead>tr>th{
                border-color: black;
            }
            .table>tbody>tr>td{
                border-top: none;
            }
        }
    </style>
@endpush
@push('body')
    <div class="order">
        <div class="order-header">
            <h3 class="text-center">
                {{ config('app.name') }}
                <br>
                {{ config('cashier.name') }}
            </h3>
            @if (!is_null($order->orderTable))
                <div class="clearfix">
                    <div class="pull-right">
                        <strong>رقم الطاولة</strong>: #{{ $order->orderTable->number }}
                    </div>
                    {{-- <div class="pull-left">
                        <strong>الصالة</strong>: {{ $order->hall->name }}
                    </div> --}}
                </div>
            @endif
            <div class="clearfix">
                <div class="pull-right">
                    <strong>رقم الطلب</strong>: #{{ $order->number }}
                </div>
                <div class="pull-left">
                    <strong>التاريخ</strong>: {{ $order->created_at->format('Y/m/d') }}
                </div>
            </div>
        </div>
        <div class="double-line"></div>
        <div class="order-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($items))
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->index + 1}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $loop->index + 1}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="order-footer">
            <div class="line"></div>
            <div class="order-details">
                @if(!isset($items))
                <table class="table">
                    <tr>
                        <th><strong>الضريبة</strong></th>
                        <td><p>{{ $order->tax }}</p></td>
                    </tr>
                    <tr>
                        <th><strong>الخصم</strong></th>
                        <td><p>{{ $order->discount }}</p></td>
                    </tr>
                    <tr>
                        <th><strong>الإجمالي</strong></th>
                        <td><p>{{ $order->total }}</p></td>
                    </tr>
                    <tr>
                        <th><strong>الصافي</strong></th>
                        <td><p>{{ $order->net }}</p></td>
                    </tr>
                </table>
                @endif
            </div>
            @if ($order->isDelivery())
                <div class="line"></div>
                <div class="delivery-details">
                    <table class="table">
                        <tr>
                            <th><strong>السائق</strong></th>
                            <td><p>{{ $order->delivery->driver->name }}</p></td>
                        </tr>
                        <tr>
                            <th><strong>العميل</strong></th>
                            <td><p>{{ $order->delivery->name }}</p></td>
                        </tr>
                        <tr>
                            <th><strong>رقم الهاتف</strong></th>
                            <td><p>{{ $order->delivery->phone }}</p></td>
                        </tr>
                        <tr>
                            <th><strong>العنوان</strong></th>
                            <td><p>{{ $order->delivery->address }}</p></td>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
        <div class="order-buttons">
            <button class="btn btn-default" onclick="window.print()">
                <i class="fa fa-print"></i>
                <span>طباعة</span>
            </button>
            <a href="{{ route('cashier.orders.index', ['type' => $order->getType('name'), 'status' => $order->getStatus('name')]) }}" class="btn btn-default">
                <i class="icon-order"></i>
                <span>الطلبات</span>
            </a>
            <a href="{{ route('cashier.dashboard') }}" class="btn btn-default">
                <i class="icon-cashier"></i>
                <span>{{ config('cashier.name') }}</span>
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i>
                <span>رجوع</span>
            </a>
        </div>
    </div>
@endpush
@push('foot')
    @if (request('view') == 'print' || isset($items))
        <script>
            window.print()
        </script>
    @endif
@endpush