@extends('layouts.dashboard.app', ['modals' => ['plan'],'datatable' => true])

@section('title')
    الباقات
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['الباقات'])
        @slot('url', ['#'])
        @slot('icon', ['users'])
    @endcomponent
    <div class="box">
        <div class="box-header">
            @permission('plans-create')
                <button type="button" style="display:inline-block; margin-left:1%" class="btn btn-primary btn-sm pull-right plan" data-toggle="modal" data-target="#plan">
                    <i class="fa fa-plus"> إضافة</i>
                </button>
            @endpermission
        </div>
        <div class="box-body">
            <table id="plans-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>القيمة</th>
                        <th>المدة</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->amount }}</td>
                            <td>{{ $plan->period }}</td>
                            
                            <td>
                                @permission('plans-create')
                                    <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit">تعديل</i></a>
                                @endpermission
                                {{-- @permission('plans-update')
                                    <button class="btn btn-warning btn-xs plan update" 
                                    data-action="{{ route('plans.update', $plan->id) }}" 
                                    data-name="{{ $plan->name }}" 
                                    data-amount="{{ $plan->amount }}" 
                                    data-period="{{ $plan->period }}"                                      
                                    data-toggle="modal" 
                                    data-target="#plan"
                                    > <i class="fa fa-eye">تعديل</i></button>
                                @endpermission --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
