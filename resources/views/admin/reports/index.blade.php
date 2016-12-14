@extends('admin.layouts.master')
@section('title', 'Master CMS')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Yönetimi</span> /
                    Form Raporları</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Form Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.forms.index') }}">Form Yönetimi</a></li>
                <li class="active">Form Raporları</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    @if(isset($result))
    <div class="alert bg-success alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Toplam <strong> ({{ $result }}) </strong> {{ $title }} bulundu.</span>
    </div>
    @endif



    <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">Form Raporları</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            {{ Form::open(['route' => ['admin.reports.query'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off']) }}

            <fieldset class="content-group vue-link">

                <div class="form-group">
                    {{ Form::label('type', 'Formlar', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::select2('type', \App\Form::types(), old('type'), ['class' => 'select-search', 'readonly']) }}
                        <span class="label label-danger">{{ $errors->first('type') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('days', 'Periyot', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::select2('days', \App\Http\Controllers\ListController::subDays(), old('days'), ['class' => 'select-search', 'readonly']) }}
                        <span class="label label-danger">{{ $errors->first('days') }}</span>
                    </div>
                </div>

            </fieldset>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Sorgula <i class="icon-arrow-right14 position-right"></i></button>
            </div>

            {{ Form::close() }}

        </div>
    </div>
    @endsection

    @section('js')
            <!-- Theme JS files -->
    <script type="text/javascript" src="/cms/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
    <script type="text/javascript" src="/cms/js/pages/form_inputs.js"></script>
    <script type="text/javascript" src="/cms/js/load-image.js"></script>

    <script>
        // Select with search
        $('.select-search').select2();
    </script>
    <!-- /theme JS files -->
@endsection
