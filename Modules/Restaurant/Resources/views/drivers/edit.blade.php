@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.edit'),
    'crumbs' => [
        ['url' => route('drivers.index'), 'title' => __('restaurant::drivers.list'), 'icon' => 'fa fa-car'],
        ['url' => route('drivers.show', $driver), 'title' => $driver->name],
        ['title' => __('restaurant::global.edit'), 'icon' => 'fa fa-edit'],
    ]
])

@push('content')
    <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        @lang('restaurant::global.edit')
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.name')</label>
                                    <input type="text" class="form-control" name="name" value="{{ $driver->name }}" placeholder="@lang('restaurant::global.name')" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.phone')</label>
                                    <input type="number" class="form-control" name="phone" value="{{ $driver->phone  }}" placeholder="@lang('restaurant::global.phone')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.address')</label>
                                    <input type="text" class="form-control" name="address" value="{{ $driver->address  }}" placeholder="@lang('restaurant::global.address')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('restaurant::global.save_changes')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endpush