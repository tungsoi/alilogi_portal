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

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

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
        .column-__actions__ {
            width: 150px !important;
        }

        .column-__actions__ button.btn, .column-__actions__ a.btn {
            width: 25px;
            margin: 0px;
            margin-right: 2px !important;
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

    @include('admin.grid-modal.recharge')
    @include('admin.grid-modal.update-profile')
</div>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

<!-- REQUIRED JS SCRIPTS -->
{!! Admin::js() !!}

</body>
</html>
