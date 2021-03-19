@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.create'))

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['قائمة الطعام', 'restaurant::global.add'])
        @slot('url', [route('menus.index'), '#'])
        @slot('icon', ['cubes', 'plus'])
    @endcomponent

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('restaurant::global.add') قائمة الطعام</h3>
            </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name" class="required"> @lang('restaurant::global.name') </label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name" class="required">المنتجات </label>
                            <select class="custom-select" name="items" id="items" multiple>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">@lang('restaurant::global.add')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@include('partials._select2')

