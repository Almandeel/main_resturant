@extends('layouts.dashboard.app')

@section('title')
    @lang('restaurant::global.create')
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['restaurant::drivers.drivers', 'add'])
        @slot('url', [route('drivers.index'),'#'])
        @slot('icon', ['car', 'plus'])
    @endcomponent
    <form action="{{ route('drivers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        @lang('restaurant::global.create')
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.name')</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('restaurant::global.name')" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.phone')</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone')  }}" placeholder="@lang('restaurant::global.phone')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('restaurant::global.address')</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address')  }}" placeholder="@lang('restaurant::global.address')">
                                </div>
                            </div>
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
                </div>
            </div>
        </div>
    </form>
@endsection