@extends('restaurant::layouts.master', [
    'title' => 'اضافة كابتن',
    'crumbs' => [
        ['url' => route('waiters.index'), 'title' => __('restaurant::waiters.list'), 'icon' => 'fa fa-car'],
        ['title' => __('restaurant::global.create'), 'icon' => 'fa fa-plus'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            @lang('restaurant::global.create')
        </div>
        <form action="{{ route('waiters.store') }}" method="POST">
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <label>@lang('restaurant::global.name')</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('restaurant::global.name')" required>
                </div>

                <div class="form-group">
                    <label>@lang('restaurant::global.phone')</label>
                    <input type="number" class="form-control" name="phone" value="{{ old('phone')  }}" placeholder="@lang('restaurant::global.phone')">
                </div>

                <div class="form-group">
                    <label>@lang('restaurant::global.address')</label>
                    <input type="text" class="form-control" name="address" required value="{{ old('address')  }}" placeholder="@lang('restaurant::global.address')">
                </div>

                <div class="form-group">
                    <label>@lang('restaurant::global.salary')</label>
                    <input type="number" class="form-control" name="salary" required value="{{ old('salary')  }}" placeholder="@lang('restaurant::global.salary')">
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <label>
                            <input type="radio" name="next" value="back" checked="true">
                            <span>@lang('restaurant::global.save_new')</span>
                        </label>
                        <label>
                            <input type="radio" name="next" value="list">
                            <span>@lang('restaurant::global.save_list')</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('restaurant::global.add')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush