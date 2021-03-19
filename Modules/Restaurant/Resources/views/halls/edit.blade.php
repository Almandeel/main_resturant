@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.edit')) 

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['restaurant::global.halls', $hall->name, 'restaurant::global.edit'])
        @slot('url', [route('halls.index'), route('halls.show', $hall), '#'])
        @slot('icon', ['cubes', 'cube','edit'])
    @endcomponent

    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.edit') - @lang('restaurant::global.hall'): {{ $hall->name }}</h3>
        </div>
        @include('partials._errors')
        <div class="box-body">
            <form action="{{ route('halls.update', $hall) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="name">{{ __('restaurant::global.name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ $hall->name }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="phone">{{ __('restaurant::global.phone') }}</label>
                        <input type="number" class="form-control" name="phone" value="{{ $hall->phone }}" min="0">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="size">{{ __('restaurant::halls.hall_size') }}</label>
                        <input type="number" class="form-control" name="size" value="{{ $hall->size }}" min="0">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="tables">{{ __('restaurant::halls.count_tables') }}</label>
                        <input type="number" class="form-control" name="number_of_tables" value="{{ $hall->number_of_tables }}" min="0">
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label>@lang('restaurant::global.manager')</label>
                        <select class="form-control" name="manager_id">
                            <option value="0">@lang('restaurant::global.choose')</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ $manager->id == $hall->manager_id ? 'selected' : '' }}>{{ $manager->employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    
                <button type="submit" class="btn btn-primary">@lang('restaurant::global.save_changes')</button>
            </form>
        </div>
    </div>
@endsection
@include('partials._select2')

