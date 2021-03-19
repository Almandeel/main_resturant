@extends('restaurant::layouts.master', [
    'title' => 'موظفو الكاشير',
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => 'موظفو الكاشير', 'icon' => 'fa fa-users'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
            <div class="box-tools">
                @permission('employees-create')
                    {{--  <button type="button" class="btn btn-primary showEmployeeModal">
                        <i class="fa fa-plus">إضافة</i>
                    </button>  --}}
                    <a href="{{ route('restaurant.cashiers.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus">إضافة</i>
                    </a>
                @endpermission
            </div>
        </div>
        <div class="box-body">
            <table id="users-table" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>اسم الموظف</th>
                        <th>المرتب</th>
                        <th>رقم الهاتف</th>
                        <th>العنوان</th>
                        <th>كاشير</th>
                        <th>الخيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cashiers as $employee)
                    
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->salary != null ? number_format($employee->salary) : 0 }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    @foreach ($employee->user->roles()->get() as $role)
                                        {{ $role->name }} | 
                                    @endforeach
                                </td>
                                <td>
                                    @permission('employees-read')
                                        <a class="btn btn-info" href="{{ route('restaurant.cashiers.show', $employee) }}"><i class="fa fa-eye"></i> عرض </a>
                                    @endpermission

                                    @permission('employees-update')
                                        <a class="btn btn-warning" href="{{ route('restaurant.cashiers.edit', $employee) }}"><i class="fa fa-edit"></i> تعديل </a>
                                    @endpermission
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>

            <input type="hidden" data-action="{{ route('restaurant.cashiers.store') }}" id="create">
        </div>
    </div>
@endpush
