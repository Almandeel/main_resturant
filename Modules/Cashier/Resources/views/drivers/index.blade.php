@extends('cashier::layouts.master', [
    'title' => __('restaurant::drivers.list'),
    'crumbs' => [
        ['title' => __('restaurant::drivers.list'), 'icon' => 'icon-driver'],
    ]
])
@push('head')
    <link rel="stylesheet" href="{{ asset('dashboard/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush


@push('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                السائقين: {{ $title }}
            </h3>
            <div class="box-tools">
                <form action="" method="get">
                    @csrf
                    <div class="btn-group">
                        <label class="btn btn-default">
                            <span>الكل</span>
                            <input type="radio" name="status" value="all" style="display: none;">
                        </label>
                        <label class="btn btn-success">
                            <span>المتوفرين</span>
                            <input type="radio" name="status" value="available" style="display: none;">
                        </label>
                        <label class="btn btn-info">
                            <span>المشغولين</span>
                            <input type="radio" name="status" value="busy" style="display: none;">
                        </label>
                        <label class="btn btn-warning">
                            <span>الغير متوفرين</span>
                            <input type="radio" name="status" value="unavailable" style="display: none;">
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body">
            <table id="drivers-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>@lang('restaurant::global.name')</th>
                        <th>@lang('restaurant::global.phone')</th>
                        <th>@lang('restaurant::global.status')</th>
                        <th>تغيير الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td><a class="btn btn-info btn-xs" href="{{ route('cashier.drivers.show', $driver->id) }}">{{ $driver->name }}</a></td>
                            <td>{{ $driver->phone }}</td>
                            <td>{!! $driver->displayStatus('text') !!}</td>
                            <td>
                                @permission('drivers-read')
                                    <a href="{{ route('cashier.drivers.show', $driver) }}" class="btn btn-info">
                                        <i class="fa fa-eye"></i>
                                        <span>عرض</span>
                                    </a>
                                @endpermission
                                @permission('drivers-update')
                                <form action="{{ route('cashier.drivers.update', $driver) }}" method="post" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    @if ($driver->isAvailable())
                                    <input type="hidden" name="status" value="{{ $driver::STATUS_UNAVAILABLE }}">
                                    <button type="submit" class="btn btn-warning" data-toggle="confirm" data-title="تحذير"
                                        data-text="سوف لن يظهر هذا السائق في الوصيل">
                                        <i class="fa fa-ban"></i>
                                        <span>غير متوفر</span>
                                    </button>
                                    @endif
                                    @if ($driver->isUnavailable())
                                    <input type="hidden" name="status" value="{{ $driver::STATUS_AVAILABLE }}">
                                    <button type="submit" class="btn btn-success" data-toggle="confirm" data-title="تأكيد"
                                        data-text="سوف يظهر هذا السائق في الوصيل" data-icon="question">
                                        <i class="fa fa-check"></i>
                                        <span>متوفر</span>
                                    </button>
                                    @endif
                                </form>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endpush

@push('foot')
    <script src="{{ asset('dashboard/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
    $(function () {
        $('input[name=status]').change(function(){
            $(this).closest('form').submit();
        })
        $('#drivers-table').DataTable({
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