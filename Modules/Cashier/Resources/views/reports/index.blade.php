@extends('cashier::layouts.master', [
    'title' => 'التقارير',
    'crumbs' => [
        ['title' => 'التقارير', 'icon' => 'fa fa-print'],
    ]
])

@push('content')
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green text-right">
                <div class="inner">
                    <h3>طلبات محلي</h3>
                </div>
                <div class="icon pull-right">
                    <i class="icon-waiter"></i>
                </div>
                <a href="{{ route('cashier.reports.orders', ['type' => 'local']) }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i> عرض
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green text-right">
                <div class="inner">
                    <h3>طلبات سفري</h3>
                </div>
                <div class="icon pull-right">
                    <i class="icon-takeaway"></i>
                </div>
                <a href="{{ route('cashier.reports.orders', ['type' => 'takeaway']) }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i> عرض
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green text-right">
                <div class="inner">
                    <h3>طلبات توصيل</h3>
                </div>
                <div class="icon pull-right">
                    <i class="icon-delivery"></i>
                </div>
                <a href="{{ route('cashier.reports.orders', ['type' => 'delivery']) }}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i> عرض
                </a>
            </div>
        </div>
    </div>
@endpush