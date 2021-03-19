@extends('layouts.dashboard.app', ['modals' => ['subscription'], 'datatable' => true ])

@section('title')
    الاشتراكات
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['الاشتراكات'])
        @slot('url', ['#'])
        @slot('icon', ['users'])
    @endcomponent
    <div class="box">
        <div class="box-header">
            @if(auth()->user()->id != 1)
                @php
                    $is_open = \App\Employee::isOpeningEntry(auth()->user()->employee);
                    // $cashier = \App\Employee::find(auth()->user()->employee_id);
                    // $opening_entry = $cashier->openingEntry(date('y-m-d'));
                    // $close_entry = $cashier->closeEntry(date('y-m-d'));
                @endphp

                @if($is_open)
                    @permission('subscriptions-create')
                        <button type="button" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right subscription" data-toggle="modal" data-target="#subscription">
                            <i class="fa fa-plus"> إضافة</i>
                        </button>
                    @endpermission
                @endif
            @endif

            @permission('subscriptions-print')
                <a  style="display:inline-block; margin-left:1%" href="{{ route('subscriptions.barcodes', 'all') }}" class="btn btn-default pull-right  btn-sm print" > <i class="fa fa-print"> طباعة </i></a>
            @endpermission

            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('subscriptions.index') }}" method="get">
                        @csrf 
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <input type="text" name="barcode"  placeholder="بحث" class="form-control" @if(request('barcode')) value="{{ request('barcode') }}" @endif>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="box-body">
            <table id="subscriptions-table" class="table datatable table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>الباقة</th>
                        <th>الحالة</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->customer->name }}</td>
                            <td>{{ $subscription->plan->name }}</td>
                            <td>
                                {{ Carbon\Carbon::parse(date('Y-m-d'))->lte($subscription->end_date) ? 'ساري' : 'منتهي' }}
                            </td>
                            <td>
                                @permission('subscriptions-read')
                                    <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-default btn-xs"><i class="fa fa-eye">عرض</i></a>
                                @endpermission

                                @permission('subscriptions-update')
                                    <button class="btn btn-warning btn-xs subscription update" data-action="{{ route('subscriptions.update', $subscription->id) }}" data-customer="{{ $subscription->customer_id }}" data-plan="{{ $subscription->plan_id }}" data-payment="{{ $subscription->payment_type }}" data-toggle="modal" data-target="#subscription"> <i class="fa fa-eye">تعديل</i></button>
                                @endpermission

                                @if(!Carbon\Carbon::parse(date('Y-m-d'))->lte($subscription->end_date))
                                    @permission('subscriptions-update')
                                        <button class="btn btn-success btn-xs subscription refresh" data-id="{{ $subscription->id }}" data-action="{{ route('subscriptions.update', $subscription->id) }}?type=resubscribe" data-customer="{{ $subscription->customer_id }}" data-plan="{{ $subscription->plan_id }}"  data-toggle="modal" data-target="#subscription"> <i class="fa fa-refresh"> اعادة الاشتراك</i></button>
                                    @endpermission
                                @endif

                                @if(Carbon\Carbon::parse(date('Y-m-d'))->lte($subscription->end_date))
                                    @permission('subscriptions-delete')
                                    <form style="display:inline-block" action="{{ route('subscriptions.destroy', $subscription->id) }}" method="post">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> الغاء الاشتراك</button>
                                    </form>
                                    @endpermission
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subscriptions->links() }}
        </div>
    </div>

@endsection
