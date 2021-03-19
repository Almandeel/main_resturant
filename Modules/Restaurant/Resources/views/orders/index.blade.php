@extends('restaurant::layouts.master', [
    'title' => 'قوائم الطعام',
    'crumbs' => [
        ['url' => route('orders.index'), 'title' => 'قوائم الطعام', 'icon' => 'fa fa-list-alt'],
    ]
])
@section('title', 'قائمة الطعام')

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">    </h3>
            
            @permission('orders-create')
                <a href="{{ route('orders.create') }}" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right" >
                    <i class="fa fa-plus"></i> @lang('restaurant::global.add') 
                </a>
            @endpermission

        </div>
        <div class="box-body">
            <table id="tables-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th> الإسم </th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->name }}</td>
                            <td>
                                @permission('orders-read')
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-xs ">
                                        <i class="fa fa-eye">@lang('restaurant::global.show')</i>
                                    </a>
                                @endpermission
                                @permission('orders-update')
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-xs ">
                                        <i class="fa fa-edit">@lang('restaurant::global.edit')</i>
                                    </a>
                                @endpermission
                                @permission('orders-delete')
                                    <a href="{{ route('orders.destroy', $order) }}?delete=true" class="btn btn-danger btn-xs ">
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

@push('js')
    <script src="{{ asset('dashboard/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
    $(function () {
        $('#tables-table').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'oLanguage'    : {
                "sEmptyTable":  "@lang('table.sEmptyTable')",
                "sInfo":    "@lang('table.sInfo')",
                "sInfoEmpty":   "@lang('table.sInfoEmpty')",
                "sInfoFiltered":    "@lang('table.sInfoFiltered')",
                "sInfoPostFix": "@lang('table.sInfoPostFix')",
                "sInfoThousands":   "@lang('table.sInfoThousands')",
                "sLengthorder":  "@lang('table.sLengthorder')",
                "sLoadingRecords":  "@lang('table.sLoadingRecords')",
                "sProcessing":  "@lang('table.sProcessing')",
                "sSearch":  "@lang('table.sSearch')",
                "sZeroRecords": "@lang('table.sZeroRecords')",
                "oPaginate": {
                    "sFirst":   "@lang('table.sFirst')",
                    "sLast":    "@lang('table.sLast')",
                    "sNext":    "@lang('table.sNext')",
                    "sPrevious":    "@lang('table.sPrevious')"
                },
                "oAria": {
                    "sSortAscending":   "@lang('table.sSortAscending')",
                    "sSortDescending":  "@lang('table.sSortDescending')"
                }
            }
        })
    })
    </script>
@endpush