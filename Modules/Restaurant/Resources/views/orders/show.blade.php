@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.show'))

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['قائمة الطعام', $menu->name])
        @slot('url', [route('menus.index'), '#'])
        @slot('icon', ['cubes', 'cube'])
    @endcomponent

    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.show') قائمة الطعام: {{ $menu->name }}</h3>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::global.id')</th>
                        <td>{{ $menu->id }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::global.name')</th>
                        <td>{{ $menu->name }}</td>
                    </tr>
                    @if(request('delete'))
                        <tr class="alert alert-warning">
                            <td colspan="2">
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <span>@lang('restaurant::global.delete_confirm')</span>
                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> @lang('restaurant::global.delete') </button>
                                </form>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>@lang('restaurant::global.options')</th>
                            <td>
                                <a class="btn btn-warning btn-xs" href="{{ route('menus.edit', $menu->id) }}"><i class="fa fa-edit"></i> @lang('restaurant::global.edit') </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
