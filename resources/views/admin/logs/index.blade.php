@extends('admin.layouts.master')
@section('title', 'Smart Panel')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/datatables_buttons.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

            <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Log Yönetimi</span> /
                    Loglar</h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.dashboard.index') }}">Sistem</a></li>
                <li class="active">{{ $title }}</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')
            <!-- Version 1.2 -->
    <div class="panel panel-flat" id="v_1_2">
        <div class="panel-heading">
            <h5 class="panel-title">{{ $title }}</h5>
        </div>

        <div class="panel-body">

            <pre class="language-javascript"><code>{{ $logs }}</code></pre>
        </div>
    </div>
    <!-- /version 1.2 -->
    @endsection

    @section('js')
            <!-- Theme JS files -->
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/pages/datatables_responsive.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/cms/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/cms/js/dataTables_drawdt.js"></script>
    <!-- /theme JS files -->
@endsection
