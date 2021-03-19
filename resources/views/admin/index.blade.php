<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if($header) | {{ $header }}@endif</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @if(!is_null($favicon = Admin::favicon()))
    <link rel="shortcut icon" href="{{$favicon}}">
    @endif

    {!! Admin::css() !!}

    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            font-family: "Tahoma" !important;
            font-size: 12px !important;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: "Tahoma" !important;
        }
        tfoot {
            display: table-row-group;
        }
        th {
            padding: 10px 10px !important;
            font-weight: 600;
            font-size: 12px !important;
        }
        .grid-row-view, .grid-row-edit, .grid-row-deposite, .grid-row-cancle, .grid-row-confirm-ordered, .grid-row-outstock {
            margin-top: 5px;
        }
        .editable-click, a.editable-click, a.editable-click:hover {
            border-bottom: none;
        }
        form .box-footer .pull-right {
            float: left !important;
            margin-left: 20px;
        }
        .mg-t-10 {
            margin-top: 10px
            }
        td, th {
            padding: 0;
            border: 1px solid #f4f4f4;
        }
        .option-hide {
            display: none;
        }
        .sidebar-menu .treeview-menu>li>a {
            font-size: 12px !important;
        }
    </style>
</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

@if($alert = config('admin.top_alert'))
    <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
        {!! $alert !!}
    </div>
@endif

<div class="wrapper">

    @include('admin::partials.header')

    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        {!! Admin::style() !!}
        <div id="app">
        @yield('content')
        </div>
        {!! Admin::script() !!}
        {!! Admin::html() !!}
    </div>

    {{-- @include('admin::partials.footer') --}}

    @if (! Admin::user()->is_updated_profile)
        <div id="modalUpdateProfile" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin cá nhân</h4>
                    <h5 style="color: red">Vui lòng cập nhật đầy đủ thông tin của bạn trước khi bắt đầu sử dụng Hệ thống.</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.auth.users.updateProfile') }}" method="post">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Mã khách hàng</label><br>
                                    <input type="text" class="form-control" placeholder="Mã khách hàng" disabled value="{{ Admin::user()->symbol_name }}">
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">Tên đăng nhập (Email)</label><br>
                                    <input type="text" class="form-control" placeholder="Tên đăng nhập (Email)" disabled value="{{ Admin::user()->username }}">
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Họ và tên
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>
                                    <input type="text" class="form-control" placeholder="{{ trans('admin.name') }}"
                                        name="name" required oninvalid="this.setCustomValidity('Vui lòng nhập đầy đủ Họ và tên')" oninput="setCustomValidity('')">
                                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Số điện thoại
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>
                                    <input type="text" class="form-control" placeholder="Số điện thoại"
                                        name="phone_number" required oninvalid="this.setCustomValidity('Vui lòng nhập đầy đủ Số điện thoại')" oninput="setCustomValidity('')">
                                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Kho nhận hàng
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>

                                    <select name="warehouse_id" class="form-control" required oninvalid="this.setCustomValidity('Vui lòng chọn Kho nhận hàng')" oninput="setCustomValidity('')">
                                        <option value="">Chọn</option>
                                        @foreach (\App\Models\Warehouse::all() as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Tỉnh / Thành phố
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>

                                    <select name="province_id" id="province" class="form-control" required oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / Thành phố')" oninput="setCustomValidity('')">
                                        <option value="">Chọn</option>
                                        @foreach (\App\Models\Province::all() as $province)
                                            <option value="{{ $province->province_id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Quận / Huyện
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>

                                    <select name="district_id" id="district" class="form-control" required oninvalid="this.setCustomValidity('Vui lòng chọn Quận / Huyện')" oninput="setCustomValidity('')">
                                        <option value="">Chọn</option>
                                        @foreach (\App\Models\District::all() as $district)
                                            <option value="{{ $district->district_id }}" class="option-hide" data-parent-province={{$district->province_id}}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Địa chỉ nhà
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>
                                    <input type="text" class="form-control" placeholder="Địa chỉ nhà"
                                        name="address" required oninvalid="this.setCustomValidity('Vui lòng nhập đầy đủ Địa chỉ nhà')" oninput="setCustomValidity('')">
                                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="">
                                        Nhân viên kinh doanh
                                        <label class="control-label" for="inputError" style="color: red">(*)</label>
                                    </label><br>

                                    <select name="staff_sale_id" class="form-control" required oninvalid="this.setCustomValidity('Vui lòng chọn Nhân viên kinh doanh')" oninput="setCustomValidity('')">
                                        <option value="">Chọn</option>
                                        @php
                                            $ids = \DB::table(config('admin.database.role_users_table'))->where('role_id', \App\User::STAFF_SALE_ROLE_ID)->get()->pluck('user_id');
                                        @endphp
                                        @foreach (\App\User::whereIn('id', $ids)->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-xs-2">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit"
                                            class="btn btn-primary btn-block btn-flat btn-sm">{{ trans('admin.submit') }}</button>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <a class="btn btn-warning btn-block btn-flat btn-sm" href="{{ route('admin.logout') }}">{{ trans('admin.logout') }}</a>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>

        <script type="text/javascript">
            $(window).on('load', function() {
                setTimeout(function() {
                    $('#modalUpdateProfile').modal({backdrop: 'static', keyboard: false});
                    $('#modalUpdateProfile').modal('show');
                }, 1000);

                $('#province').on('change', function () {
                    let province_id = $(this).val();
                    $('#district option').removeClass("option-hide");
                    $('#district option').addClass("option-hide");
                    $('#district option[data-parent-province="'+province_id+'"]').removeClass("option-hide");
                    console.log(province_id);
                });
            });
        </script>
    @endif

</div>

{{-- <button id="totop" title="Go to top" style="display: none;"><i class="fa fa-chevron-up"></i></button> --}}

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

<!-- REQUIRED JS SCRIPTS -->
{!! Admin::js() !!}

</body>
</html>
