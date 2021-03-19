@extends('restaurant::layouts.master', [
    'title' => __('restaurant::global.tables'),
    'crumbs' => [
        ['title' => __('restaurant::global.tables'), 'icon' => 'fa fa-cubes'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"> @lang('restaurant::tables.list') </h3>
            
            @permission('tables-create')
                <a href="{{ route('tables.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                    <i class="fa fa-plus"></i> @lang('restaurant::global.add') 
                </a>
            @endpermission

        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover text-center datatable">
                <thead>
                    <tr>
                        <th>@lang('restaurant::tables.number')</th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table)
                        <tr>
                            <td>{{ $table->number }}</td>
                            <td>
                                @permission('tables-read')
                                    <a href="{{ route('tables.show', $table) }}" class="btn btn-info btn-xs ">
                                        <i class="fa fa-eye">@lang('restaurant::global.show')</i>
                                    </a>
                                @endpermission
                                @permission('tables-update')
                                    <a href="{{ route('tables.edit', $table) }}" class="btn btn-warning btn-xs ">
                                        <i class="fa fa-edit">@lang('restaurant::global.edit')</i>
                                    </a>
                                @endpermission
                                @permission('tables-delete')
                                    <a href="{{ route('tables.destroy', $table) }}?delete=true" class="btn btn-danger btn-xs ">
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