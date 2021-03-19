@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.show'),
    'crumbs' => [
        ['url' => route('drivers.index'), 'title' => __('restaurant::drivers.list'), 'icon' => 'fa fa-car'],
        ['url' => route('drivers.show', $driver), 'title' => $driver->name],
    ]
])

@push('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h3>{{ $driver->name }}</h3>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
        @csrf
        {{ method_field('DELETE') }}
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <table class="table table-borderd">
                            <tr>
                                <th>@lang('restaurant::global.name')</th>
                                <td>{{ $driver->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('restaurant::global.phone')</th>
                                <td>{{ $driver->phone }}</td>
                            </tr>
                            <tr>
                                <th>@lang('restaurant::global.address')</th>
                                <td>{{ $driver->address }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        @if(request()->delete)
                            @permission('drivers-delete')
                                <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('restaurant::global.delete')</button>
                            @endpermission
                        @else
                            @permission('drivers-update')
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('restaurant::global.edit')</a>
                            @endpermission
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endpush