@extends('restaurant::layouts.master', [
    'title' => __('restaurant::halls.list'),
    'crumbs' => [
        ['url' => route('halls.index'), 'title' => __('restaurant::halls.list'), 'icon' => 'fa fa-home'],
    ]
])


@push('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title"> @lang('restaurant::halls.list') </h3>
        @permission('halls-create')
            <a href="{{ route('halls.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                <i class="fa fa-plus"></i> @lang('restaurant::global.add') 
            </a>
        @endpermission
    </div>
    <div class="box-body">
        <table id="halls-table" class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>@lang('restaurant::global.name')</th>
                    <th>@lang('restaurant::global.manager')</th>
                    <th>@lang('restaurant::halls.count_tables')</th>
                    <th>@lang('restaurant::global.options')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($halls as $hall)
                    <tr>
                        <td>{{ $hall->name }}</td>
                        <td>{{ $hall->manager->employee->name }}</td>
                        <td>{{ $hall->number_of_tables }}</td>
                        <td>
                            @permission('halls-read')
                                <a href="{{ route('halls.show', $hall) }}" class="btn btn-info btn-xs ">
                                    <i class="fa fa-eye">@lang('restaurant::global.show')</i>
                                </a>
                            @endpermission
                            @permission('halls-update')
                                <a href="{{ route('halls.edit', $hall) }}" class="btn btn-warning btn-xs ">
                                    <i class="fa fa-edit">@lang('restaurant::global.edit')</i>
                                </a>
                            @endpermission
                            @permission('halls-delete')
                                <a href="{{ route('halls.destroy', $hall) }}?delete=true" class="btn btn-danger btn-xs ">
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