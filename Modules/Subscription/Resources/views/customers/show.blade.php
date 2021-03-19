@extends('layouts.dashboard.app', [
	'modals' => ['transfer', 'customer', 'chequeInput'],
	'datatable' => true,
])

@section('title')
    العميل: {{ $customer->name }}
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['العملاء','عرض'])
        @slot('url', [route('subcustomers.index'), '#'])
        @slot('icon', ['users', 'eye'])
    @endcomponent
        <div class="box">
            <div class="box-header">
                <table class="table table-borderd">
                    <tr>
                        <th>الاسم</th>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr>
                        <th>الهاتف</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">الاشتراكات</h3>
            </div>
            <div class="box-body">
                <table id="subscriptions-table" class="table datatable table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الباقة</th>
                            <th>تاريخ الاشتراك</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>{{ $subscription->customer->name }}</td>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ $subscription->start_date }}</td>
                                <td>{{ $subscription->end_date }}</td>
                                <td>
                                    @if($subscription->deleted_at)
                                        ملغي
                                    @else 
                                        {{ Carbon\Carbon::parse(date('Y-m-d'))->lte($subscription->end_date) ? 'ساري' : 'منتهي' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
@push('js')

@endpush