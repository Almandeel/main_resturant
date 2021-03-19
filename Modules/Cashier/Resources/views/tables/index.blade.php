@extends('cashier::layouts.master', [
    'title' => 'الطاولات',
    'crumbs' => [
        ['title' => 'الطاولات', 'icon' => 'fa fa-circle'],
    ]
])
@push('content')
    <div class="row">
        @foreach ($tables as $table)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center" style="margin: 15px 0;">
                <a href="{{ route('cashier.tables.show', $table) }}" class="table-{{ $table->isBusy() ? 'busy' : 'free' }}" title="{{ $table->status ? 'مشغولة' : 'متاحه' }}" style="width: 150px; height: 150px;">
                    <span class="table-counter">{{ $table->number }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endpush
