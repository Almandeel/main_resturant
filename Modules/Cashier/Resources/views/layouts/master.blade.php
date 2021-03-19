@extends('layouts.dashboard.dashboard', [
    'skin' => 'green'
])
@push('dashboard_navbar_items')
    @if(auth()->user()->id != 1)
        @php 
            $is_open = \App\Employee::isOpeningEntry(auth()->user()->employee);
            // $cashier = \App\Employee::find(auth()->user()->employee_id);
            // $opening_entry = $cashier->openingEntry());
            // $close_entry = $cashier->closeEntry());
        @endphp

        @if($is_open)
            @permission('orders-create')
                <li class="{{ (request()->segment(2) == 'pos') ? 'active' : '' }}"><a href="{{ route('cashier.pos') }}"><i class="icon-pos"></i><span>نافذة البيع</span></a></li>
            @endpermission
        @endif
        @permission('orders-read')
            <li class="{{ (request()->segment(2) == 'orders') ? 'active' : '' }}"><a href="{{ route('cashier.orders.index') }}"><i class="icon-order"></i><span>الطلبات</span></a></li>
        @endpermission
        
        @permission('safes-read')
            <li class="{{ (request()->segment(2) == 'safe') ? 'active' : '' }}"><a href="{{ route('cashier.safe') }}"><i class="fa fa-money"></i><span>الخزنة</span></a></li>
        @endpermission

        @permission('reports-read')
            <li class="{{ (request()->segment(2) == 'reports') ? 'active' : '' }}"><a href="{{ route('cashier.reports.index') }}"><i class="fa fa-print"></i><span>التقارير</span></a></li>
        @endpermission

        @stack('navbar_items')
    @endif
@endpush
@push('dashboard_navbar_left_items')
    @stack('navbar_left_items')
@endpush
@push('dashboard_sidebar_items')
    @permission('menus-read')
        <li class="{{ (request()->segment(2) == 'menus') ? 'active' : '' }}"><a href="{{ route('cashier.menus.index') }}"><i class="icon-menu"></i><span>قوائم الطعام</span></a></li>
    @endpermission
    @permission('tables-read')
        <li class="{{ (request()->segment(2) == 'tables') ? 'active' : '' }}"><a href="{{ route('cashier.tables.index') }}"><i class="icon-table"></i><span>الطاولات</span></a></li>
    @endpermission
    @permission('waiters-read')
        <li class="{{ (request()->segment(2) == 'waiters') ? 'active' : '' }}"><a href="{{ route('cashier.waiters.index') }}"><i class="icon-waiter"></i><span>الكباتن</span></a></li>
    @endpermission
    @permission('drivers-read')
        <li class="{{ (request()->segment(2) == 'drivers') ? 'active' : '' }}"><a href="{{ route('cashier.drivers.index') }}"><i class="icon-driver"></i><span>السائقين</span></a></li>
    @endpermission

    @permission('subscriptions-read')
        <li class="{{ (request()->segment(2) == 'subscriptions') ? 'active' : '' }}"><a href="{{ route('subscriptions.index') }}"><i class="fa fa-list"></i><span>  الاشتراكات </span></a></li>
    @endpermission
    @stack('sidebar_items')
@endpush
@push('dashboard_content')
    @stack('content')
@endpush