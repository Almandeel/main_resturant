@extends('cashier::layouts.master', [
    'title' => 'الكباتن',
    'crumbs' => [
        ['title' => 'الكباتن', 'icon' => 'icon-waiter'],
    ]
])
@push('content')
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
            <table id="waiters-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>@lang('restaurant::global.name')</th>
                        <th>@lang('restaurant::global.phone')</th>
                        <th>@lang('restaurant::global.status')</th>
                        <th>@lang('restaurant::global.options')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waiters as $waiter)
                        <tr>
                            <td>{{ $waiter->name }}</td>
                            <td>{{ $waiter->phone }}</td>
                            <td>{!! $waiter->displayStatus('html') !!}</td>
                            <td>
                                @permission('waiters-read')
                                    <a class="btn btn-info btn-xs" href="{{ route('cashier.waiters.show', $waiter->id) }}"><i class="fa fa-eye"></i> <span>@lang('restaurant::global.show')</span> </a>
                                @endpermission

                                {{--  @permission('waiters-update')
                                    <a class="btn btn-warning btn-xs" href="{{ route('cashier.accordionwaiters.edit', $waiter->id) }}"><i class="fa fa-edit"></i> @lang('restaurant::global.edit') </a>
                                @endpermission

                                @permission('waiters-delete')
                                    <a class="btn btn-danger btn-xs" href="{{ route('cashier.accordionwaiters.show', $waiter->id) }}?delete=true"><i class="fa fa-trash"></i> @lang('restaurant::global.delete') </a>
                                @endpermission  --}}
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
        $('#waiters-table').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'oLanguage'    : {
                "sEmptyTable":  "@lang('restaurant::table.sEmptyTable')",
                "sInfo":    "@lang('restaurant::table.sInfo')",
                "sInfoEmpty":   "@lang('restaurant::table.sInfoEmpty')",
                "sInfoFiltered":    "@lang('restaurant::table.sInfoFiltered')",
                "sInfoPostFix": "@lang('restaurant::table.sInfoPostFix')",
                "sInfoThousands":   "@lang('restaurant::table.sInfoThousands')",
                "sLengthMenu":  "@lang('restaurant::table.sLengthMenu')",
                "sLoadingRecords":  "@lang('restaurant::table.sLoadingRecords')",
                "sProcessing":  "@lang('restaurant::table.sProcessing')",
                "sSearch":  "@lang('restaurant::table.sSearch')",
                "sZeroRecords": "@lang('restaurant::table.sZeroRecords')",
                "oPaginate": {
                    "sFirst":   "@lang('restaurant::table.sFirst')",
                    "sLast":    "@lang('restaurant::table.sLast')",
                    "sNext":    "@lang('restaurant::table.sNext')",
                    "sPrevious":    "@lang('restaurant::table.sPrevious')"
                },
                "oAria": {
                    "sSortAscending":   "@lang('restaurant::table.sSortAscending')",
                    "sSortDescending":  "@lang('restaurant::table.sSortDescending')"
                }
            }
        })
    })
    </script>
@endpush