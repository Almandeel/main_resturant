{{--  @extends('cashier::layouts.master', [
    'title' => 'نافذة البيع',
    'crumbs' => [
        ['title' => 'نافذة البيع', 'icon' => 'fa fa-stack-overflow'],
    ]
])
@push('head')
@endpush
@push('content')
    
@endpush  --}}

<!DOCTYPE HTML>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Bootstrap-ecommerce by Vosidiy">
        <title>{{ config('cashier.name') }} | نافذة البيع</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboard/img/cashier-logo-green.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('dashboard/img/cashier-logo-green.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('dashboard/img/cashier-logo-green.png') }}">
        <!-- jQuery -->
        <!-- Bootstrap4 files-->
        <link href="{{ asset('pos/assets/css/bootstrap.custom.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('pos/assets/css/ui.css') }}" rel="stylesheet" type="text/css" />
        <!-- Font awesome 5 -->
        <link href="{{ asset('pos/assets/fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('pos/assets/css/OverlayScrollbars.css') }}" type="text/css" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('dashboard/css/font-awesome-rtl.min.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/parsley.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/css/rtl.css') }}">
        
        <style>
            body, h1, h2, h3, h4, h5, h6 {
                font-family: 'Cairo', sans-serif !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                direction: rtl;
            }
            .content-header>.breadcrumb{
                float: right btn-add-to-cart;
                left: auto;
                right btn-add-to-cart: 10px;
            }
            .p-sticky{
                position: sticky;
                z-index: 11;
            }

            .top-0{
                top: 0px;
            }

            .top-15{
                top: 15px;
            }

            .top-30{
                top: 30px;
            }

            .top-70{
                top: 70px;
            }

            .top-90{
                top: 90px;
            }

            .bottom-15{
                bottom: 15px;
            }

            .bottom-30{
                bottom: 30px;
            }

            .avatar {
                vertical-align: middle;
                width: 35px;
                height: 35px;
                border-radius: 50%;
            }

            .bg-default,
            .btn-default {
                background-color: #f2f3f8;
            }

            .btn-error {
                color: #ef5f5f;
            }
            .item-status{
                position: absolute;
                top: -10px;
                right btn-add-to-cart: -10px;
                z-index: 1;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                text-align: center;
                line-height: 43px;
                border: 4px dotted;
            }

            .item-status.unavailable{
                width: 90px;
                height: 55px;
                line-height: 43px;
            }
            .modal-dialog {
                width: 100%;
                height: 100%;
                padding: 0;
                max-width: 90%;
                max-height: 90%;
            }

            .modal-content {
                height: 100%;
                border-radius: 0;
            }
            .modal-body{
                overflow-y: auto;
            }
            .full-height{
                height: 100% !important;
            }
            .full-width{
                width: 100% !important;
            }
            .image-wrapper{
                position: relative;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid rgba(0, 0, 0, 0.125);
                border-radius: 0.25rem;
            }
            .image-wrapper .image-previewer {
                border-radius: 0.2rem 0.2rem 0 0;
                overflow: hidden;
                position: relative;
                height: 220px;
                text-align: center;
                display: block;
                background: #ffffff no-repeat center;
                background-size: contain;
            }
            .image-wrapper input {
                display: none;
            }
            .image-wrapper .btn{
                border-radius: 0;
            }

            .input-group label{margin-top: 4px;}
            .logo{
                margin-left: 15px;
            }
            .menu-link.nav-link{
                color: #00a65a;
                border-radius: 0;
            }
            .menu-link.nav-link:hover{
                background-color: rgb(0 166 90 / 10%);
            }
            .menu-link.nav-link.active:hover{
                background-color: #00a65a;
                cursor: default;
            }
            .btn-circle{
                border-radius: 50%;
            }
            .header-main .btn-circle{
                width: 40px;
                height: 40px;
                line-height: 40px;
                text-align: center;
                padding: 0;
            }
            .fa-sign-out{
                transform: rotate(180deg);
            }
            label.table{
                display: inline-block;
                position: relative;
                width: 100px;
                height: 100px;
                /* line-height: 100px; */
                text-align: center;
                background-color: #fff;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                /* padding: 15px; */
                border-radius: 50%;
                border: 1px solid transparent;
                transition: 0.3s all ease-in-out;
                border: 1px solid transparent;
            }
            label.table:hover{
                border-color: green;
                cursor: pointer;
                background-color: rgba(0, 255, 0, 0.10);
            }
            label.table.active {
                background-image: url({{ url('pos/assets/images/table-free.svg') }});
                background-color: rgba(0, 255, 0, 0.10);
                border-color: green;
            }
            label.table.active {
                cursor: default;
            }
            .table-counter{
                font-size: 5rem;
                font-weight: bold;
                color: #ffffff;
                display: block;
                text-shadow: -1px -1px green, 1px 1px green, -2px -2px green, 2px 2px green;
                transition: 0.3s all ease-in-out;
                position: absolute;
                top: 0px;
                left: 0px;
                width: 100px;
                height: 100px;
            }
            label.table.active .table-counter{
                width: 70px;
                height: 70px;
                top: -36px;
                left: 10px;
                padding: 10px;
                border: 2px solid green;
                font-size: 2rem;
                text-align: center;
                line-height: 55px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.95);
            }

            fieldset{
                text-align: right;
            }

            .b-none{
                border: none;
            }
            .modal-dialog .nav-tabs .nav-link.active, .modal-dialog .nav-tabs .nav-item.show .nav-link{
                border-radius: 0;
            }
            .modal-dialog .nav-tabs .nav-link{
                min-width: 180px;
                text-align: center;
                padding: 15px;
                {{--  border: 0px;  --}}
            }
            .modal-dialog .nav-tabs .nav-link.active:hover{
                cursor: default;
                color: initial;
            }
            .modal-dialog .nav-tabs .nav-link:hover{
                color: green;
            }
            .submit-btn-group{
                display: none;
            }

            .btn-group.full-width {
                display: flex;
            }
            
            .btn-group.full-width .btn {
                flex: 1;
            }
        </style>
    </head>

    <body>
        <form id="pos-form" action="{{ is_null($order) ? route('cashier.orders.store') : route('cashier.orders.update', $order) }}" method="post">
            @if (!is_null($order))
                @method('PUT')
            @endif
            @csrf
            <section class="header-main p-sticky top-0 bg-white" style="z-index: 20;border-bottom: 1px solid rgb(40 167 69 / 0.2);">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="brand-wrap text-right">
                                <img class="logo" src="{{ asset('dashboard/img/cashier-logo-green.png') }}">
                                {{--  <span class="logo">
                                    <i class="fas fa-cash-register"></i>
                                </span>  --}}
                                <h2 class="logo-text">
                                    <span>{{ config('cashier.name') }}</span>
                                    <span>|</span>
                                    <span>نافذة البيع</span>
                                </h2>
                            </div> <!-- brand-wrap.// -->
                        </div>
                        <div class="col-lg-6 col-sm-6">
                        </div> <!-- col.// -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="widgets-wrap d-flex justify-content-end">
                                <div class="widget-header">
                                    <a href="#" class="icontext">
                                        <a href="{{ route('cashier.dashboard') }}" class="btn btn-circle btn-outline-primary m-btn m-btn--icon m-btn--icon-only" data-toggle="tooltip" data-placement="bottom" title="الكاشير">
                                            <i class="fa fa-money"></i>
                                        </a>
                                    </a>
                                </div> <!-- widget .// -->
                                <div class="widget-header">
                                    <a href="#" class="icontext">
                                        <a href="{{ route('dashboard.index') }}" class="btn btn-circle btn-outline-info m-btn m-btn--icon m-btn--icon-only" data-toggle="tooltip" data-placement="bottom" title="الرئيسية">
                                            <i class="fa fa-home"></i>
                                        </a>
                                    </a>
                                </div> <!-- widget .// -->
                                <div class="widget-header">
                                    <a href="#" class="icontext">
                                        <button id="logout-btn" type="button" class="logout btn btn-circle btn-outline-warning m-btn m-btn--icon m-btn--icon-only" data-toggle="tooltip" data-placement="bottom" title="تسجيل الخروج">
                                            <i class="fa fa-sign-out"></i>
                                        </button>
                                    </a>
                                </div> <!-- widget .// -->
                                {{--  <div class="widget-header dropdown">
                                    <a href="#" class="ml-3 icontext" data-toggle="dropdown" data-offset="20,10">
                                        <img src="{{ asset('pos/assets/images/avatars/bshbsh.png') }}" class="avatar"
                                            alt="">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right btn-add-to-cart">
                                        <a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt"></i> Logout</a>
                                    </div> <!--  dropdown-menu .// -->
                                </div> <!-- widget  dropdown.// -->  --}}
                            </div> <!-- widgets-wrap.// -->
                        </div> <!-- col.// -->
                    </div> <!-- row.// -->
                </div> <!-- container.// -->
            </section>
            <!-- ========================= SECTION CONTENT ========================= -->
            <section class="section-content padding-y-sm bg-default">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 card padding-y-sm card ">
                            @if ($errors->any())
                                <div class="alert alert-warning text-right">
                                    <ol>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                            <ul id="menus-links" class="nav bg radius nav-pills nav-fill mb-3 bg p-sticky top-70" style="box-shadow: 0 3px 3px rgba(49, 97, 49, 0.15);" role="tablist"></ul>
                            <span id="menu-items">
                            </span>
                        </div>
                        <div class="col-md-4">
                            <div class="p-stickyy top-700">
                                <div class="card">
                                    <span id="cart">
                                        <table id="cart-table" class="table table-hover shopping-cart-wrap">
                                            <thead class="text-muted">
                                                <tr>
                                                    <th scope="col" width="120">#</th>
                                                    <th scope="col">المنتج</th>
                                                    <th scope="col" width="120">الكمية</th>
                                                    <th scope="col" width="120">السعر</th>
                                                    <th scope="col" class="text-right btn-add-to-cart" width="200">حذف</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @if (!is_null($order))
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>
                                                                <figure class="media">
                                                                    <div class="img-wrap"><img src="{{ $item->item->image_url }}" class="img-thumbnail img-xs">
                                                                    </div>
                                                                    <figcaption class="media-body">
                                                                        <h6 class="title text-truncate">{{ $item->item->name }}</h6>
                                                                    </figcaption>
                                                                </figure>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
                                                                    <input type="hidden" name="units[]" class="unit-id" value="{{ $item->item->id }}">
                                                                    <input type="hidden" name="prices[]" class="unit-price" value="{{ $item->price }}">
                                                                    <input type="hidden" name="quantities[]" class="unit-quantity" value="{{ $item->quantity }}">
                                                                    <button type="button" class="m-btn btn btn-default quantity-decrease"><i class="fa fa-minus"></i></button>
                                                                    <button type="button" class="m-btn btn btn-default quantity" disabled>{{ $item->quantity }}</button>
                                                                    <button type="button" class="m-btn btn btn-default quantity-increase"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="price-wrap">
                                                                    <var class="price">{{ $item->price }}</var>
                                                                </div> <!-- price-wrap .// -->
                                                            </td>
                                                            <td class="text-right">
                                                                <button type="button" class="btn btn-outline-danger btn-remove-item"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif --}}
                                            </tbody>
                                        </table>
                                    </span>
                                </div> <!-- card.// -->
                                <div class="box">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label for="discount">الخصم</label>
                                                </div>
                                                <input type="number" id="discount" name="discount" class="form-control" value="{{ is_null($order) ? 0 : $order->discount }}" step="0.01">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label for="tax">الضريبة</label>
                                                </div>
                                                <input type="number" id="tax" name="tax" class="form-control" value="{{ is_null($order) ? 0 : $order->tax }}" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    {{--  <dl class="dlist-align">
                                        <dt>Tax: </dt>
                                        <dd class="text-right btn-add-to-cart">12%</dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Discount:</dt>
                                        <dd class="text-right btn-add-to-cart"><a href="#">0%</a></dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Sub Total:</dt>
                                        <dd class="text-right btn-add-to-cart">$215</dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Total: </dt>
                                        <dd class="text-right btn-add-to-cart h4 b"> $215 </dd>
                                    </dl>  --}}
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <strong class="float-right">الضريبة</strong>
                                            <span id="tax-text" class="float-left">0</span>
                                        </div>
                                        <div class="clearfix">
                                            <strong class="float-right">الخصم</strong>
                                            <span id="discount-text" class="float-left">0</span>
                                        </div>
                                        <div class="clearfix">
                                            <strong class="float-right">الإجمالي</strong>
                                            <span id="total-text" class="float-left">0</span>
                                        </div>
                                        <div class="clearfix">
                                            <strong class="float-right">الصافي</strong>
                                            <span id="net-text" class="float-left">0</span>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <div class="text-center">
                                            <div class="form-group">
                                                <div class="btn-group full-width" role="group" aria-label="Options buttons">
                                                    @if (is_null($order))
                                                        <button type="button" disabled class="btn btn-success btn-lg btn-submit btn-order-submit">
                                                            {{--  btn-default btn-error">  --}}
                                                            <i class="fa fa-external-link"></i>
                                                            <span>سفري</span>
                                                        </button>
                                                        <button type="button" disabled data-tab="#tablesTab" class="btn-submit btn-show-submit-modal btn btn-info btn-lg btn-show-submit-modal">
                                                            <i class="fa fa-th"></i>
                                                            <span>طاولات</span>
                                                        </button>
                                                        <button type="button" disabled data-tab="#deliveryTab" class="btn-submit btn-show-submit-modal btn btn-warning btn-lg btn-show-submit-modal">
                                                            <i class="fa fa-car"></i>
                                                            <span>توصيل</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{ url()->previous() }}" class="btn btn-lg btn-danger btn-block">
                                                    {{--  btn-default btn-error">  --}}
                                                    <i class="fa fa-times-circle"></i>
                                                    <span>إلغاء</span>
                                                </a>
                                                @if(request()->order_id) 
                                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                                    {{--  btn-default btn-error">  --}}
                                                    <i class="fa fa-check"></i>
                                                    <span>تم</span>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- box.// -->
                            </div>
                        </div>
                    </div>
                </div><!-- container //  -->
            </section>
            <!-- ========================= SECTION CONTENT END// ========================= -->
            {{--  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>  --}}
            <!-- ========================= ITEM MODAL START// ========================= -->
            <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="itemModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row full-height">
                                <div class="col">
                                    <div class="image-wrapper full-height">
                                        <div id="item-image" class="image-previewer full-height"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <table id="item-table" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>المنتج</th>
                                                <td class="item"></td>
                                            </tr>
                                            <tr>
                                                <th>الوحدة</th>
                                                <td class="unit"></td>
                                            </tr>
                                            <tr>
                                                <th>السعر</th>
                                                <td class="price"></td>
                                            </tr>
                                            <tr>
                                                <th>الحالة</th>
                                                <td class="status"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========================= ITEM MODAL END// ========================= -->
            
            <script src="{{ asset('pos/assets/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('pos/assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('pos/assets/js/OverlayScrollbars.js') }}" type="text/javascript"></script>
            {{--<!-- Sweetalert2 js -->--}}
            <script src="{{ asset('dashboard/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('dashboard/plugins/sweetalert2/sweetalert2.min.css') }}">
            <script>
                function sweet(title, text, icon = 'info'){
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: icon,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'حسنا',
                    })
                }
            </script>
            @if (is_null($order))
            <!-- ========================= SUBMIT MODAL START// ========================= -->
            <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header p-0 b-none">
                            <ul class="nav nav-tabs full-width">
                                <li class="nav-item">
                                    <a href="#tablesTab" class="nav-link active" aria-controls="tablesTab" role="tab" data-toggle="tab">
                                        <i class="fa fa-th"></i>
                                        <span>الطاولات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#deliveryTab" aria-controls="deliveryTab" role="tab" data-toggle="tab" class="nav-link">
                                        <i class="fa fa-car"></i>
                                        <span>توصيل</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-body scroll-only-y p-0">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tablesTab">
                                    <div class="p-4">
                                        <div id="tables-wrapper" class="row"></div>
                                        <div id="tables-order-details" class="form-inline ml-2" style="display: none;">
                                            <div class="form-group ml-4">
                                                <label for="table_id">الطاولة</label>
                                                <select id="table_id" name="table_id" class="form-control">
                                                    <option value="">إختر الطاولة</option>
                                                    @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}">{{ $table->number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group ml-4">
                                                <label for="waiter_id">الكابتن</label>
                                                <select id="waiter_id" name="waiter_id" class="form-control">
                                                    <option value="">إختر الكابتن</option>
                                                    @foreach ($waiters as $waiter)
                                                    <option value="{{ $waiter->id }}">{{ $waiter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="tables-btn-wrapper" class="form-group ml-4">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-th"></i>
                                                    <span>عرض الطاولات</span>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-order-submit">
                                                    <i class="fa fa-check-circle"></i>
                                                    <span>إكمال</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="deliveryTab">
                                    <fieldset class="p-4">
                                        {{--  <legend>بيانات توصيل</legend>  --}}
                                        <div class="from-group">
                                            <label for="delivery_name">الإسم</label>
                                            <input type="text" id="delivery_name" name="delivery_name" class="form-control">
                                        </div>
                                        <div class="from-group">
                                            <label for="delivery_phone">رقم الهاتف</label>
                                            <input type="text" id="delivery_phone" name="delivery_phone" class="form-control">
                                        </div>
                                        <div class="from-group mb-4">
                                            <label for="delivery_address">العنوان</label>
                                            <textarea rows="4" id="delivery_address" name="delivery_address" class="form-control"></textarea>
                                        </div>
                                        <div class="from-group">
                                            {{--  <label for="driver_id">السائق</label>  --}}
                                            <div class="input-group">
                                                <select id="driver_id" name="driver_id" class="form-control">
                                                    <option value="">إختر السائق</option>
                                                    @foreach ($drivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary btn-order-submit">
                                                        <i class="fa fa-check-circle"></i>
                                                        <span>إكمال</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row full-width">
                                <div class="col">
                                    {{--  <div class="form-inline">
                                        <div class="form-group ml-2">
                                            <select name="driver_id" class="form-control">
                                                <option>إختر السائق</option>
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group ml-2">
                                            <select name="waiter_id" class="form-control">
                                                <option>إختر الكابتن</option>
                                                @foreach ($waiters as $waiter)
                                                    <option value="{{ $waiter->id }}">{{ $waiter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-check-circle"></i>
                                            <span>إكمال</span>
                                        </button>
                                    </div>  --}}
                                </div>
                                <div class="col clearfix">
                                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">
                                        <i class="fa fa-times-circle"></i>
                                        <span>إغلاق</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========================= SUBMIT MODAL END// ========================= -->
            <script>
                $(function(){
                    setTables();
                    $('.btn-show-submit-modal').click(function(){
                        let tab = $(this).data('tab');
                        if(tab){
                            $('#submitModal .nav-tabs a[href="'+ tab +'"]').tab('show')
                            resetTabs(tab)
                        }
                        $('#submitModal').modal('show')
                    })
                    $('#submitModal .nav-tabs .nav-link').click(function(){
                        resetTabs($(this).attr('href'))
                        
                    })
                    $("#submitModal").on("hidden.bs.modal", function () {
                        resetTabs();
                    });
                    $(document).on('change', 'input.table-id', function(e){
                        e.preventDefault()
                        $('label.table').removeClass('active')
                        $(this).closest('label.table').addClass('active')
                        $('#table_id').val($(this).val())

                        $('#tables-wrapper').fadeOut()
                        $('#tables-order-details').fadeIn()
                    })

                    $(document).on('click', '#tables-btn-wrapper .btn', function(e){
                        e.preventDefault()
                        $('#tables-order-details').fadeOut()
                        $('#tables-wrapper').fadeIn()
                        resetTabs()
                    })
                })
                function resetTabs(tab = null){
                    console.log(tab)
                    $('select#table_id').val($($('select#table_id').children('option:first')).val())
                    $('select#waiter_id').val($($('select#waiter_id').children('option:first')).val())
                    $('label.table').removeClass('active')
                    $('label.table input[type=radio]').prop('checked', false)
                    $('#tables-order-details').hide()
                    $('#tables-wrapper').show()
                    
                    $('#delivery_name').val('')
                    $('#delivery_phone').val('')
                    $('#delivery_address').val('')
                    $('select#driver_id').val($($('select#driver_id').children('option:first')).val())

                    if(tab == '#deliveryTab'){
                        $('#delivery_name').attr('required', true)
                        $('#delivery_phone').attr('required', true)
                        $('#delivery_address').attr('required', true)
                        $('select#driver_id').attr('required', true)
                        
                        $('select#table_id').removeAttr('required')
                        $('select#waiter_id').removeAttr('required')
                    }
                    else if(tab == '#tablesTab'){
                        $('select#table_id').attr('required', true)
                        $('select#waiter_id').attr('required', true)
                        
                        $('select#driver_id').removeAttr('required')
                        $('#delivery_name').removeAttr('required')
                        $('#delivery_phone').removeAttr('required')
                        $('#delivery_address').removeAttr('required')
                    }
                    else{
                        $('select#table_id').removeAttr('required')
                        $('select#waiter_id').removeAttr('required')
                        $('select#driver_id').removeAttr('required')
                        $('#delivery_name').removeAttr('required')
                        $('#delivery_phone').removeAttr('required')
                        $('#delivery_address').removeAttr('required')
                    }
                }
                function setTables(){
                    let wrapper = $('#tables-wrapper');
                    let tables = ``;
                    let table_html = ``;
                    @foreach ($tables as $table)
                        table_html = `
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center" style="margin: 15px 0;">
                                <label class="table">
                                    <span class="table-counter">{{ $table->number }}</span>
                                    <input type="radio" name="table" class="table-id" value="{{ $table->id }}">
                                </label>
                            </div>
                        `;
                        tables += table_html;
                    @endforeach

                    wrapper.html(tables)
                }
            </script>
            @endif
            <script src="{{ asset('libs/parsleyjs/parsley.js')}}"></script>
            <script src="{{ asset('libs/parsleyjs/i18n/ar.js')}}"></script>
            <script>
                let menus_keys = @json(array_keys($menus));
                let menus = @json($menus);
                let waiters = @json($waiters);
                let tables = @json($tables);
                let menus_links = $('#menus-links');
                let page_unloaded = true;
                $(function() {
                    $('#logout-btn').click(function(){
                        let that = $(this);
                        Swal.fire({
                            title: 'تحذير',
                            text: 'سوف يتم تسجيل خروجك من النظام استمرار؟',
                            icon: 'warning',
                            confirmButtonColor: '#ffc107',
                            confirmButtonTextColor: '#212529',
                            confirmButtonClass: 'btn btn-warning',
                            confirmButtonText: 'إستمرار',
                            cancelButtonText: 'إلغاء',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonColor: '#00a65a',
                            showCancelButton: true,
                        }).then(function(result){
                            if(result.value){
                                $('form#logout-form').submit()
                            }
                        })
                    })
                    @if (!is_null($order))
                        calcuteTotals()
                    @endif
                    $(window).bind('beforeunload', function(){
                        page_unloaded = false;
                    });
                    $('form').parsley();
                    window.Parsley.on('form:success', function(){
                        $('button[type="submit"]').attr('disabled', true);
                    })
                    $('.btn-order-submit').click(function(e){
                        e.preventDefault()
                        let summary = calcuteTotals();
                        if(summary.net > 0){
                            Swal.fire({
                                title: 'خيارات الرجوع',
                                html:`
                                    <label class="btn btn-success btn-next">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة جديد</span>
                                        <input type="hidden" name="next" value="{{ route('cashier.pos') }}">
                                    </label>
                                    <label class="btn btn-info btn-next">
                                        <i class="fa fa-list"></i>
                                        <span>الطلبات</span>
                                        <input type="hidden" name="next" value="{{ route('cashier.orders.index') }}">
                                    </label>
                                    <label class="btn btn-secondary btn-next">
                                        <i class="fa fa-arrow-left"></i>
                                        <span>السابق</span>
                                        <input type="hidden" name="next" value="{{ url()->previous() }}">
                                    </label>
                                `,
                                showConfirmButton: false,
                                showCancelButton: true,
                                cancelButtonText: 'إغلاق',
                                focusConfirm: false,
                                /*preConfirm: () => {
                                    let safeId = safeable ? Swal.getPopup().querySelector('#safeId').value : null;
                                    let accountId = accountable ? Swal.getPopup().querySelector('#accountId').value : null;
                                    if (accountId == 0 && accountable) {
                                    Swal.showValidationMessage(`{{ str_replace(':attribute', __("accounting::validation.attributes.account"), __("accounting::validation.required")) }}`)
                                    }
                                    return {safeId: safeId, accountId: accountId}
                                }*/
                            })

                            /*$(this).closest('form').submit();
                            $('button.btn-order-submit').attr('disabled', true);
                            if(page_unloaded){
                                $('button.btn-order-submit').attr('disabled', false);
                            }*/
                        }else{
                            sweet('المنتجات فارغة', 'قم بإختيار المنتجات اولا', 'error')
                        }
                    })
                    $(document).on('click', '.btn-next', function(e){
                        e.preventDefault()
                        let pos_form = $('#pos-form')
                        let field_next = $('#pos-form input[name="next"]')
                        if(field_next.length){
                            field_next.val($(this).find('input[name=next]').val())
                        }else{
                            pos_form.append(`<input id="next" type="hidden" name="next" value="`+ $(this).find('input[name=next]').val() +`">`)
                        }
                        pos_form.submit()
                    })
                    $('[data-toggle="tooltip"]').tooltip();

                    //The passed argument has to be at least a empty object or a object with your desired options
                    //$("body").overlayScrollbars({ });
                    $("#items").height(552);
                    $("#items").overlayScrollbars({
                        overflowBehavior : {
                            x : "hidden",
                            y : "scroll"
                        }
                    });
                    $(".scroll-only-y").overlayScrollbars({
                        overflowBehavior : {
                            x : "hidden",
                            y : "scroll"
                        }
                    });
                    $(".scroll-only-x").overlayScrollbars({
                        overflowBehavior : {
                            x : "scroll",
                            y : "hidden"
                        }
                    });
                    $("#cart").height(445);
                    $("#cart").overlayScrollbars({ });
                    generateMenusLinks($('#menus-links'))
                    showMenuItems()

                    $(document).on('click', '.menu-link', function(e){
                        $('#menu-items').hide()
                        e.preventDefault()
                        let menu_key = $(this).data('menu-key') ? $(this).data('menu-key') : 'all';
                        showMenuItems(menu_key)
                        $('.menu-link').removeClass('show')
                        $('.menu-link').removeClass('active')
                        $(this).addClass('show')
                        $(this).addClass('active')
                        $('#menu-items').fadeIn()
                    })

                    $(document).on('click', '.item-previewer', function(e){
                        e.preventDefault()
                        let menu_key = $(this).data('menu-key')
                        let item_key = $(this).data('item-key')
                        let unit_key = $(this).data('unit-key')
                        let menu = menus[menu_key];
                        let item = menu.items[item_key];
                        let unit = item[unit_key];
                        let item_modal = $('#itemModal')
                        let item_table = $('#itemModal table#item-table')
                        let item_table_item = $('#itemModal table#item-table td.item')
                        let item_table_unit = $('#itemModal table#item-table td.unit')
                        let item_table_price = $('#itemModal table#item-table td.price')
                        let item_table_status = $('#itemModal table#item-table td.status')
                        let item_image = $('#itemModal #item-image')
                        let item_modal_label = $('#itemModalLabel')

                        // Fill mdoal data
                        item_modal_label.text(unit.name)
                        item_image.css("background-image", "url("+ unit.image_url +")")
                        item_table_item.text(unit.item_name)
                        item_table_unit.text(unit.unit_name)
                        item_table_price.text(unit.price)
                        item_table_status.text(unit.status.title)


                        item_modal.modal('show')
                    })

                    $(document).on('click', '.btn-add-to-cart', function(e){
                        e.preventDefault()
                        let menu_key = $(this).data('menu-key')
                        let item_key = $(this).data('item-key')
                        let unit_key = $(this).data('unit-key')
                        let menu = menus[menu_key];
                        let item = menu.items[item_key];
                        let unit = item[unit_key];
                        let cart_table = $('#cart-table')
                        let current_unit = cart_table.find('input.unit-id[value='+ unit.id +']');
                        if(current_unit.length){
                            let quantity_input = current_unit.siblings('input.unit-quantity')
                            let quantity_button = current_unit.siblings('button.quantity')
                            let quantity = Number(quantity_input.val())
                            // let new_quantity = quantity + 1;
                            quantity += 1;
                            quantity_input.val(quantity)
                            quantity_button.text(quantity)
                        }else{
                            let row = `
                                <tr data-menu-key="`+ menu_key +`" data-item-key="`+ item_key +`" data-unit-key="`+ unit_key +`">
                                    <td>` + (cart_table.find('tbody tr').length + 1) + `</td>
                                    <td>
                                        <figure class="media">
                                            <div class="img-wrap"><img src="` + unit.image_url + `" class="img-thumbnail img-xs">
                                            </div>
                                            <figcaption class="media-body">
                                                <h6 class="title text-truncate">` + unit.name + `</h6>
                                            </figcaption>
                                        </figure>
                                    </td>
                                    <td class="text-center">
                                        <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
                                            <input type="hidden" name="units[]" class="unit-id" value="` + unit.id + `">
                                            <input type="hidden" name="prices[]" class="unit-price" value="` + unit.price + `">
                                            <input type="hidden" name="quantities[]" class="unit-quantity" value="1">
                                            <button type="button" class="m-btn btn btn-default quantity-decrease"><i class="fa fa-minus"></i></button>
                                            <button type="button" class="m-btn btn btn-default quantity" disabled>1</button>
                                            <button type="button" class="m-btn btn btn-default quantity-increase"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="price">` + unit.price + `</var>
                                        </div> <!-- price-wrap .// -->
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-danger btn-remove-item"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            `;
        
                            cart_table.find('tbody').append(row)
                        }
                        calcuteTotals()
                    })

                    $(document).on('click', '.quantity-increase', function(e){
                        e.preventDefault()
                        let quantity_input = $(this).siblings('input.unit-quantity')
                        let quantity_button = $(this).siblings('button.quantity')
                        let quantity = Number(quantity_input.val())
                        // let new_quantity = quantity + 1;
                        quantity += 1;
                        quantity_input.val(quantity)
                        quantity_button.text(quantity)
                        calcuteTotals()
                    })

                    $(document).on('click', '.quantity-decrease', function(e){
                        e.preventDefault()
                        let quantity_input = $(this).siblings('input.unit-quantity')
                        let quantity_button = $(this).siblings('button.quantity')
                        let quantity = Number(quantity_input.val())
                        if(quantity > 1){
                            quantity -= 1;
                            quantity_input.val(quantity)
                            quantity_button.text(quantity)
                            calcuteTotals()
                        }else{
                            sweet('عذرا', 'الكمية لا يمكن ان تكون اقل من 1', 'warning')
                        }
                    })

                    $(document).on('click', '.btn-remove-item', function(e){
                        e.preventDefault()
                        let row = $(this).closest('tr')
                        let confirmed = confirm('سوف يتم حذف العنصر من السلة استمرار؟')
                        if(confirmed){
                            row.remove()
                            calcuteTotals(true)
                        }
                    })

                    $(document).on('change, keyup', 'input#tax, input#discount', function(e){
                        e.preventDefault()
                        calcuteTotals()
                    })
                });
                function calcuteTotals(set_count = false){
                    let quantity_inputs = $('table#cart-table input.unit-quantity');
                    let tax_input = $('input#tax');
                    let discount_input = $('input#discount');
                    let discount = Number(discount_input.val());
                    let tax = Number(tax_input.val());
                    let total = 0;
                    for(let index = 0; index < quantity_inputs.length; index++){
                        let quantity_input = $(quantity_inputs[index]);
                        let quantity = quantity_input.val();
                        let price = quantity_input.siblings('input.unit-price').val();
                        total += Number(quantity) * Number(price)
                        
                        if(set_count){
                            let row = quantity_input.closest('tr')
                            row.find('counter').text(index + 1)
                        }
                    }

                    let net = total;
                    net -= discount;
                    net += tax;

                    $('#tax-text').text(tax.toFixed(2))
                    $('#discount-text').text(discount.toFixed(2))
                    $('#total-text').text(total.toFixed(2))
                    $('#net-text').text(net.toFixed(2))

                    /*if(net > 0){
                        $('.submit-btn-group').fadeIn()
                    }else{
                        $('.submit-btn-group').fadeOut()
                    }*/

                    $('.btn-submit').prop('disabled', !(net > 0))
                    return {tax: tax, discount: discount, total: total, net: net};
                }
                function generateMenusLinks(menus_links){
                    let links = `
                        <li class="nav-item">
                            <a class="menu-link nav-link active show" data-toggle="pill" href="#nav-tab-all" data-menu-key="all">
                                <i class="fa fa-tags"></i>
                                <span>الكل</span>
                            </a>
                        </li>
                    `;
                    for(let index = 0; index < menus_keys.length; index++)
                    {
                        let menu_key = menus_keys[index]
                        let menu = menus[menu_key]
                        links += `
                            <li class="nav-item">
                                <a class="menu-link nav-link" data-toggle="pill" href="#nav-tab-card" data-menu-key="` + menu_key + `">
                                    <i class="fa fa-tags"></i>
                                    <span>` + menu.name + `</span>
                                </a>
                            </li>
                        `
                    }

                    menus_links.html(links)
                }
                function showMenuItems(menu_key = 'all'){
                    let menu_items = $('#menu-items')
                    let items_html = `<div class="row">`;
                    items_html += generateMenuItems(menu_key);
                    items_html += `</div>`;
                    menu_items.html(items_html);
                }
                function generateMenuItems(menu_key){
                    let menu_items_html = ``;
                    if(menu_key == 'all'){
                        for(let index = 0; index < menus_keys.length; index++){
                            let mk = menus_keys[index];
                            menu_items_html += generateMenuItems(mk)
                        }
                    }else{
                        // if(menus.hasOwnProperty(menu_key + '')){
                        if(menu_key in menus){
                            let menu = menus[menu_key];
                            let items = menu.items;
                            let items_keys = Object.keys(items);
                            for(let index = 0; index < items_keys.length; index++){
                                let item_key = items_keys[index];
                                let units = items[item_key];
                                for(let i = 0; i < items_keys.length; i++){
                                    let unit_key = i;
                                    let unit = units[unit_key];
                                    if(unit){
                                        menu_items_html += `
                                            <div class="col col-xs-12 col-sm-6 col-md-4">
                                                <figure class="card card-product">
                                                    <span class="badge-new">`+ menu.name +`</span>
                                                    <span class="item-status badge-`+ unit.status.class +` `+ unit.status.name +`">`+ unit.status.title +`</span>
                                                    <div class="img-wrap">
                                                        <img src="`+ unit.image_url +`">
                                                        <a class="btn-overlay item-previewer" data-menu-key="`+ menu_key +`" data-item-key="`+ item_key +`" data-unit-key="`+ unit_key +`" href="#"><i class="fa fa-search-plus"></i> عرض</a>
                                                    </div>
                                                    <figcaption class="info-wrap">
                                                        <a href="#" class="title">`+ unit.name +`</a>
                                                        <div class="action-wrap">
                                                            <a href="#" class="btn btn-primary btn-sm float-right btn-add-to-cart" data-menu-key="`+ menu_key +`" data-item-key="`+ item_key +`" data-unit-key="`+ unit_key +`">
                                                                <i class="fa fa-cart-plus"></i>
                                                                <span>إضافة</span> 
                                                            </a>
                                                            <div class="price-wrap h5">
                                                                <span class="price-new">`+ unit.price +`</span>
                                                            </div> <!-- price-wrap.// -->
                                                        </div> <!-- action-wrap -->
                                                    </figcaption>
                                                </figure> <!-- card // -->
                                            </div> <!-- col // -->
                                        `;
                                    }
                                }
                            }
                        }
                    }

                    return menu_items_html;
                }
            </script>
        </form>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </body>

</html>