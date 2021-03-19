@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.create'))

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['restaurant::global.halls', 'restaurant::global.add'])
        @slot('url', [route('halls.index'), '#'])
        @slot('icon', ['cubes', 'plus'])
    @endcomponent

    <form action="{{ route('halls.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <div class="box">
                    <div class="box-header">
                        <h3>@lang('restaurant::global.add') @lang('restaurant::global.hall')</h3>
                    </div>

                    <div class="box-body">

                        <div class="form-group col-md-6">
                            <label for="name" class="required"> @lang('restaurant::global.name') </label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone"> @lang('restaurant::global.phone') </label>
                            <input type="number" class="form-control" name="phone" min="0">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="size"> @lang('restaurant::halls.hall_size') </label>
                            <input type="number" class="form-control" name="size" min="0">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tables"> @lang('restaurant::halls.count_tables') </label>
                            <input type="number" class="form-control" name="number_of_tables" min="0">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="manager_id"> @lang('restaurant::global.manager') </label>
                            <select class="form-control" name="manager_id">
                                <option value="0">@lang('restaurant::global.choose')<option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">@lang('restaurant::global.save_changes')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@include('partials._select2')
