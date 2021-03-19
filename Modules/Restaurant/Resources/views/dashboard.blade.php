@extends('layouts.dashboard.base', [
    'skin' => 'blue',
])
@push('head')
    <style>
        .content{

        }
    </style>
@endpush
@push('body')
    <h1 class="text-center text-aqua">قسم المطاعم</h1>
    <hr>
    <div class="container">
        <div class="row">
            @permission('employees-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>موظفو الكاشير</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('restaurant.cashiers.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
            @permission('menus-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>قوائم الطعام</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="{{ route('menus.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
            @permission('tables-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>الطاولات</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-circle"></i>
                    </div>
                    <a href="{{ route('tables.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
            @permission('waiters-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>الكباتن</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{ route('waiters.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
        {{--  </div>
        <div class="row">  --}}
            @permission('drivers-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>السائقين</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-user-circle-o"></i>
                    </div>
                    <a href="{{ route('drivers.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
            @permission('halls-read')
            <div class="col-lg-4 col-xs-12">
                <div class="small-box bg-aqua text-right">
                    <div class="inner">
                        <h3>الصالات</h3>
                    </div>
                    <div class="icon pull-right">
                        <i class="fa fa-table"></i>
                    </div>
                    <a href="{{ route('halls.index') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                </div>
            </div>
            @endpermission
            @permission('menus-read')
                <div class="col-lg-12 col-xs-12">
                    <div class="small-box bg-aqua text-right">
                        <div class="inner">
                            <h3>{{ config('cashier.name') }}</h3>
                        </div>
                        <div class="icon pull-right">
                            <i class="fa fa-windows"></i>
                        </div>
                        <a href="{{ route('cashier.dashboard') }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i>  عرض  </a>
                    </div>
                </div>
			@endpermission
        </div>
    </div>
@endpush
