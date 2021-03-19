@extends('restaurant::layouts.master', [
    'title' => __('restaurant::waiters.list'),
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => __('restaurant::waiters.list'), 'icon' => 'fa fa-car'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">   
            @permission('waiters-create')       
            <a  href="{{ route('waiters.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                <i class="fa fa-user-plus">@lang('restaurant::global.add')</i>
            </a>
            @endpermission

        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover text-center datatable">
                <thead>
                    <tr>
                        <th>@lang('restaurant::global.name')</th>
                        <th>@lang('restaurant::global.phone')</th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waiters as $waiter)
                        <tr>
                            <td>{{ $waiter->name }}</td>
                            <td>{{ $waiter->phone }}</td>
                            <td>
                                @permission('waiters-read')
                                    <a class="btn btn-info btn-xs" href="{{ route('waiters.show', $waiter->id) }}"><i class="fa fa-eye"></i> @lang('restaurant::global.show') </a>
                                @endpermission

                                @permission('waiters-update')
                                    <a class="btn btn-warning btn-xs" href="{{ route('waiters.edit', $waiter->id) }}"><i class="fa fa-edit"></i> @lang('restaurant::global.edit') </a>
                                @endpermission

                                @permission('waiters-delete')
                                    <a class="btn btn-danger btn-xs" href="{{ route('waiters.show', $waiter->id) }}?delete=true"><i class="fa fa-trash"></i> @lang('restaurant::global.delete') </a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endpush