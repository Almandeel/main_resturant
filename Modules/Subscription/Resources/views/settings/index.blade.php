@extends('layouts.dashboard.app', ['modals' => ['setting'], 'datatable' => true])

@section('title')
    الاعدادات
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['الاعدادات'])
        @slot('url', ['#'])
        @slot('icon', ['users'])
    @endcomponent
    <div class="box">
        <div class="box-header">
            {{-- @permission('settings-create')
                <button type="button" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right showsettingModal create" data-toggle="modal" data-target="#settings">
                    <i class="fa fa-plus"> إضافة</i>
                </button>
            @endpermission --}}
        </div>
        <div class="box-body">
            <table id="settings-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>القيمة</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $setting->name }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                @permission('settings-update')
                                    <a class="btn btn-warning btn-xs settings  update" data-action="{{ route('settings.update', $setting->id) }}" data-name="{{ $setting->name }}"
                                    data-value="{{ $setting->value }}"><i class="fa fa-edit"></i> تعديل </a>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
