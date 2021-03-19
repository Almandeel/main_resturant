@extends('restaurant::layouts.master', [
    'title' => 'تعديل موظف كاشير',
    'crumbs' => [
        ['url' => route('restaurant.cashiers.index'), 'title' => 'موظفو الكاشير', 'icon' => 'fa fa-users'],
        ['url' => route('restaurant.cashiers.show', $cashier), 'title' => $cashier->name, 'icon' => 'fa fa-user'],
        ['title' => __('restaurant::global.edit'), 'icon' => 'fa fa-edit'],
    ]
])

@push('content')
    <form class="form" action="{{ route('restaurant.cashiers.update', $cashier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <div class="col-xs-12 col-md-6">
                <label>الاسم</label>
                <input class="form-control name" autocomplete="off" type="text" name="name" value="{{ $cashier->name }}" placeholder="الاسم" required />
            </div>
            <div class="col-xs-12 col-md-6">
                <label>المرتب</label>
                <input class="form-control" autocomplete="off" type="number" name="salary" value="{{ $cashier->salary }}" placeholder="المرتب" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xs-12 col-md-6">
                <label>رقم الهاتف</label>
                <input class="form-control" autocomplete="off" type="text" name="phone" value="{{ $cashier->phone }}" placeholder="رقم الهاتف" required />
            </div>
            <div class="col-xs-12 col-md-6">
                <label> العنوان</label>
                <input class="form-control" autocomplete="off" type="text" name="address" value="{{ $cashier->address }}" placeholder="رقم العنوان" required />
            </div>
        </div>
        <fieldset id="user-details">
            <legend>بيانات الدخول</legend>
            <div class="form-group">
                <div class="form-group">
                    <label>@lang('users.username')</label>
                    <input type="text" class="form-control required" name="username" value="{{ $user->username }}" value="{{ old('username') }}"
                        placeholder="@lang('users.username')" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('users.password')</label>
                        <input id="password" type="password" class="form-control" name="password"
                            placeholder="@lang('users.password')">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد كلمة المرور" data-parsley-equalto="#password">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>
                        <input type="radio" name="next" value="back" checked="checked">
                        <span>حفظ وعرض التعديل</span>
                    </label>
                    <label style="margin-right: 15px;">
                        <input type="radio" name="next" value="list">
                        <span>حفظ و عرض على القائمة</span>
                    </label>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check"></i> إكمال العملية</button>
                </div>
            </div>
            <div class="form-group">
                <div class="box-group" id="accordion">
                    <div class="panel">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    صلاحيات إضافية
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="form-group">
                                <table id="users-table" class="table table-bordered table-hover text-right" dir="ltr">
                                    <thead>
                                        <tr>
                                            <th>الصلاحية </th>
                                            <th>الصلاحية</th>
                                            <th>الصلاحية</th>
                                            <th>الصلاحية</th>
                                        </tr>
                                    </thead>
                                    @php $missing_col = count($permissions) % 4 @endphp
                                    @php $col = 4 - $missing_col @endphp
                                    @foreach ($permissions as $index=>$permission)
                                    @if($index % 4 == 0 )
                                    <tr>
                                        @endif
                                        @if( ( count($permissions) - ($index) ) > $missing_col )
                                        <td>
                                            <label>
                                                {{ __('permissions.'.$permission->name)  }}
                                                <input type="checkbox" class="flat-red" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $cashier_permissions) ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        @else
                                        @if($missing_col == 1)
                                        @for ($i = 0; $i < $col; $i++) <td>
                                            <label>-</label>
                                            </td>
                                            @endfor
                                            @endif
                                            @if($missing_col > 0)
                                            <td>
                                                <label>
                                                    {{ __('permissions.'.$permission->name)  }}
                                                    <input type="checkbox" class="flat-red" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $cashier_permissions) ? 'checked' : '' }}>
                                                </label>
                                            </td>
                                            @php $missing_col-- @endphp
                                            @endif
        
                                            @endif
                                            @if($index + 1 % 4 == 0)
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>
                                        <input type="radio" name="next" value="back">
                                        <span>حفظ وعرض التعديل</span>
                                    </label>
                                    <label style="margin-right: 15px;">
                                        <input type="radio" name="next" value="list">
                                        <span>حفظ و عرض على القائمة</span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check"></i> إكمال العملية</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
@endpush
@push('foot')
    <script>
        $(function(){
            /*
            $('input[name=next]').change(function(){
                if($(this).prop('checked')){
                    $('input[value=' + $(this).val() + ']').prop('checked', true)
                }
            })
            */
        })
    </script>
@endpush