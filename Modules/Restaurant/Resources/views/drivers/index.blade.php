@extends('restaurant::layouts.master', [
    'title' => __('restaurant::drivers.list'),
    'datatable' => true,
    'crumbs' => [
        ['url' => route('drivers.index'), 'title' => __('restaurant::drivers.list'), 'icon' => 'fa fa-car'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">   
            @permission('drivers-create')       
            <a  href="{{ route('drivers.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                <i class="fa fa-user-plus">@lang('restaurant::global.add')</i>
            </a>
            @endpermission

        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover text-center datatable-paged">
                <thead>
                    <tr>
                        <th>@lang('restaurant::global.name')</th>
                        <th>@lang('restaurant::global.phone')</th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->phone }}</td>
                            <td>
                                @permission('drivers-read')
                                    <a class="btn btn-info btn-xs" href="{{ route('drivers.show', $driver->id) }}"><i class="fa fa-eye"></i> @lang('restaurant::global.show') </a>
                                @endpermission

                                @permission('drivers-update')
                                    <a class="btn btn-warning btn-xs" href="{{ route('drivers.edit', $driver->id) }}"><i class="fa fa-edit"></i> @lang('restaurant::global.edit') </a>
                                @endpermission

                                @permission('drivers-delete')
                                    <a class="btn btn-danger btn-xs" href="{{ route('drivers.show', $driver->id) }}?delete=true"><i class="fa fa-trash"></i> @lang('restaurant::global.delete') </a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endpush