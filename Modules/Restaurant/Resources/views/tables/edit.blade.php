@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.edit'),
    'crumbs' => [
        ['title' => __('restaurant::global.tables'), 'icon' => 'fa fa-cubes'],
        ['title' => $table->number, 'icon' => 'fa fa-cube'],
        ['title' => __('restaurant::global.edit'), 'icon' => 'fa fa-edit'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.edit') - @lang('restaurant::global.table'): {{ $table->number }}</h3>
        </div>
        @include('partials._errors')
        <div class="box-body">
            <form action="{{ route('tables.update', $table) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="number" class="required">{{ __('restaurant::tables.number') }}</label>
                    <input type="number" class="form-control" name="number" value="{{ $table->number }}" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">@lang('restaurant::global.save_changes')</button>
            </form>
        </div>
    </div>
@endpush
@include('partials._select2')