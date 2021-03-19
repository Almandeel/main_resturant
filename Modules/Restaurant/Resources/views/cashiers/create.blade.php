@extends('restaurant::layouts.master', [
    'title' => 'إنشاء موظف كاشير',
    'crumbs' => [
        ['url' => route('restaurant.cashiers.index'), 'title' => 'موظفو الكاشير', 'icon' => 'fa fa-users'],
        ['title' => __('restaurant::global.create'), 'icon' => 'fa fa-user-plus'],
    ]
])

@push('content')
    <form class="form" action="{{ route('restaurant.cashiers.store') }}" method="POST">
        @csrf
        <div class="form-group row">
            <div class="col-xs-12 col-md-6">
                <label>الاسم</label>
                <input class="form-control name" autocomplete="off" type="text" name="name" placeholder="الاسم" required />
            </div>
            <div class="col-xs-12 col-md-6">
                <label>المرتب</label>
                <input class="form-control" autocomplete="off" type="number" name="salary" placeholder="المرتب" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xs-12 col-md-6">
                <label>رقم الهاتف</label>
                <input class="form-control" autocomplete="off" type="text" name="phone" placeholder="رقم الهاتف" required />
            </div>
            <div class="col-xs-12 col-md-6">
                <label> العنوان</label>
                <input class="form-control" autocomplete="off" type="text" name="address" placeholder="رقم العنوان" required />
            </div>
        </div>
        <fieldset id="user-details">
            <legend>بيانات الدخول</legend>
            <div class="form-group">
                <div class="form-group">
                    <label>@lang('users.username')</label>
                    <input type="text" class="form-control required" name="username" value="{{ old('username') }}"
                        placeholder="@lang('users.username')" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('users.password')</label>
                        <input id="password" type="password" class="form-control required" name="password"
                            placeholder="@lang('users.password')" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تأكيد كلمة المرور</label>
                        <input type="password" class="form-control required" name="password_confirmation" placeholder="تأكيد كلمة المرور" data-parsley-equalto="#password" required>
                    </div>
                </div>

            </div>

            <fieldset>
                <legend>نوع الكاشير</legend>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="checkbox" value="market" class="flat-red" name="type" required>
                        <label>كاشير السوبرماركت</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="checkbox" value="resturant" class="flat-red" name="type" required>
                        <label>كاشير المطعم</label>
                    </div>
                </div>
            </fieldset>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>
                        <input type="radio" name="next" value="back">
                        <span>حفظ و اضافة جديد</span>
                    </label>
                    <label style="margin-right: 15px;">
                        <input type="radio" name="next" value="list" checked="checked">
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
                                                <input type="checkbox" class="flat-red" name="permissions[]"
                                                    value="{{ $permission->id }}">
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
                                                    <input type="checkbox" class="flat-red" name="permissions[]"
                                                        value="{{ $permission->id }}">
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
                                        <span>حفظ و اضافة جديد</span>
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