@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.create'),
    'crumbs' => [
        ['title' => __('restaurant::global.tables'), 'icon' => 'fa fa-cubes'],
        ['title' => __('restaurant::global.add'), 'icon' => 'fa fa-plus'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('restaurant::global.add') @lang('restaurant::global.table')</h3>
        </div>
        @include('partials._errors')
        <div class="box-body">
            <form action="{{ route('tables.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="number" class="required"> @lang('restaurant::tables.number') </label>
                    <input type="number" class="form-control" name="number" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">@lang('restaurant::global.add')</button>
                </div>
            </div>
        </div>
    </form>
@endpush
@include('partials._select2')