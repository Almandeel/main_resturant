@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.edit'))

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['قائمة الطعام', $menu->name, 'restaurant::global.edit'])
        @slot('url', [route('menus.index'), route('menus.show', $menu), '#'])
        @slot('icon', ['cubes', 'cube','edit'])
    @endcomponent

    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.edit') - قائمة الطعام: {{ $menu->name }}</h3>
        </div>
        @include('partials._errors')
        <div class="box-body">
            <form action="{{ route('menus.update', $menu) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="name" class="required">{{ __('restaurant::global.name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ $menu->name }}" required>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="name" class="required">المنتجات </label>
                    <select class="custom-select" name="items" id="items" multiple>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">@lang('restaurant::global.save_changes')</button>
            </form>
        </div>
    </div>
@endsection
@include('partials._select2')

