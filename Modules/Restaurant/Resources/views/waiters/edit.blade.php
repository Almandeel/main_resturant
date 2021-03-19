@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.edit'),
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => __('restaurant::waiters.list'), 'icon' => 'fa fa-car'],
        ['url' => route('menus.show', $waiter), 'title' => $waiter->name, 'icon' => 'fa fa-car'],
        ['title' => __('restaurant::global.edit'), 'icon' => 'fa fa-edit'],
    ]
])

@push('content')
    <form action="{{ route('waiters.update', $waiter->id) }}" method="POST">
        @csrf
        {{ method_field('PUT') }}
        <div class="box">
            <div class="box-header">
                @lang('restaurant::global.edit')
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>@lang('restaurant::global.name')</label>
                    <input type="text" class="form-control" name="name" value="{{ $waiter->name }}" placeholder="@lang('restaurant::global.name')" required>
                </div>
                <div class="form-group">
                    <label>@lang('restaurant::global.phone')</label>
                    <input type="number" class="form-control" name="phone" value="{{ $waiter->phone  }}" placeholder="@lang('restaurant::global.phone')">
                </div>
                <div class="form-group">
                    <label>@lang('restaurant::global.address')</label>
                    <input type="text" class="form-control" name="address" value="{{ $waiter->address  }}" placeholder="@lang('restaurant::global.address')">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('restaurant::global.save_changes')</button>
        </div>
    </form>
@endpush