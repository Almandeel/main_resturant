@extends('restaurant::layouts.master', [
    'title' => 'قوائم الطعام',
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => 'قوائم الطعام', 'icon' => 'fa fa-list-alt'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">قوائم الطعام</h3>
            @permission('menus-create')
                <a href="{{ route('menus.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                    <i class="fa fa-plus"></i> @lang('restaurant::global.add') 
                </a>
            @endpermission
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover text-center datatable">
                <thead>
                    <tr>
                        <th> الإسم </th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>
                                @permission('menus-read')
                                    <a href="{{ route('menus.show', $menu) }}" class="btn btn-info btn-xs ">
                                        <i class="fa fa-eye">@lang('restaurant::global.show')</i>
                                    </a>
                                @endpermission
                                @permission('menus-update')
                                    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-warning btn-xs ">
                                        <i class="fa fa-edit">@lang('restaurant::global.edit')</i>
                                    </a>
                                @endpermission
                                @permission('menus-delete')
                                    <a href="{{ route('menus.destroy', $menu) }}?delete=true" class="btn btn-danger btn-xs ">
                                        <i class="fa fa-trash">@lang('restaurant::global.delete')</i>
                                    </a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endpush