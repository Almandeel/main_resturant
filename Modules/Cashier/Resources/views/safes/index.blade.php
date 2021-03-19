@extends('cashier::layouts.master', [
    'title' => 'الخزن',
    'datatables' => true,
    'crumbs' => [
        ['title' => 'الخزن', 'icon' => 'fa fa-money'],
    ]
])

@push('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"></h3>
            <div class="box-tools">
                <form action="" class="form-inline" style="display: inline-block;">
                    <div class="form-group">
                        <span>
                            <i class="fa fa-filter"></i>
                            <span>فرز</span><i class="fa fa-hand-o-left"></i> &nbsp;
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="type">النوع</label>
                        <select name="type" id="type" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="from_date">من</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}"/>
                    </div>
                    <div class="form-group">
                        <label for="to_date">إلى</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            <span>فرز</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body">
            <table id="tables-table" class="table table-bordered table-striped table-hover text-center datatable">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <th>الكمية</th>
                        <th>القيمة</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endpush