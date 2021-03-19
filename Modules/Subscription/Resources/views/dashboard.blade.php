@extends('layouts.dashboard.app', ['modals' => ['subscription']])
@section('title')
لوحة التحكم
@endsection
@section('content')
<div class="">
    <section class="content">
        @permission('subscriptions-delete')
            <div class="col-lg-4 col-xs-12">
                <a href="{{ route('subscriptions.index') }}">
                    <div style="border-radius: 10%" class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $subscriptions->count() }}</h3>
                            <p>الاشتراكات</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-pie-chart"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-xs-12">
                <a href="{{ route('plans.index') }}">
                    <div style="border-radius: 10%" class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $plans->count() }}</h3>
                            <p>الباقات</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-pie-chart"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-xs-12">
                <a href="{{ route('subcustomers.index') }}">
                    <div style="border-radius: 10%" class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $customers->count() }}</h3>
                            <p>العملاء</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-pie-chart"></i>
                        </div>
                    </div>
                </a>
            </div>
        @endpermission

        @if(auth()->user()->id != 1)
            @php
                $is_open = \App\Employee::isOpeningEntry(auth()->user()->employee);
                // $opening_entry = $cashier->openingEntry(date('y-m-d'));
                // $close_entry = $cashier->closeEntry(date('y-m-d'));
            @endphp

            @if($is_open)
                @permission('subscriptions-read')
                    @foreach ($plans as $plan)
                        <div class="col-lg-3 col-xs-12">
                            <a href="#" data-plan="{{ $plan->id }}" class="subscription no-plan" data-toggle="modal" data-target="#subscription">
                                <div style="border-radius: 10%" class="small-box bg-blue-gradient">
                                    <div class="inner text-center">
                                        <h4>{{ $plan->name }}</h4>
                                    </div>
                                    <div class="icon">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endpermission
            @endif
        @endif

        
    </section>
</div>
@endsection
