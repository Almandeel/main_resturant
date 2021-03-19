@extends('layouts.dashboard.app')

@section('title', __('restaurant::global.show'))

@section('content')

    @component('partials._breadcrumb')
        @slot('title', ['restaurant::global.halls', $hall->name])
        @slot('url', [route('halls.index'), '#'])
        @slot('icon', ['cubes', 'cube'])
    @endcomponent

    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.hall'): {{ $hall->name }}</h3>
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
                        <td>{{ $hall->id }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::global.name')</th>
                        <td>{{ $hall->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::halls.hall_size')</th>
                        <td>{{ $hall->size }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::halls.count_tables')</th>
                        <td>{{ ($hall->number_of_tables) }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">@lang('restaurant::global.manager')</th>
                        <td>{{ $hall->manager->employee->name }}</td>
                    </tr>
                    
                    @if(request('delete'))
                        <tr class="alert alert-warning">
                            <td colspan="2">
                                <form action="{{ route('halls.destroy', $hall) }}" method="POST">
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
                                <a class="btn btn-warning btn-xs" href="{{ route('halls.edit', $hall->id) }}"><i class="fa fa-edit"></i> @lang('restaurant::global.edit') </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

     <div class="box">
        <div class="box-header">
            <h4>@lang('restaurant::global.tables'): </h4>
        </div>
        <div class="box-body">
            <div class="col-md-6">
                @foreach($hall->tables as $table)
                    <p>{{ $table->number }} {{ $table->status }}</p>
                @endforeach
            </div>
        </div>
    </div>

@endsection
