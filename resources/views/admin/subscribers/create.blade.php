@extends('admin.layouts.master')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
@endsection

    @section('page-header')

            <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Abone Yönetimi</span> /
                    @if(!isset($subscriber)) Abone Ekle @else Abone Bilgileri @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Abone Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.stores.index') }}">Abone Yönetimi</a></li>
                <li class="active">@if(!isset($subscriber)) Abone Ekle @else Abone Bilgileri @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')
    <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($subscriber)) Abone Ekle @else Abone Bilgileri @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            @if (!isset($subscriber))
                {{ Form::open(['route' => ['admin.subscribers.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($subscriber, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.subscribers.update', $subscriber->id],
                  'method' => 'put',
                  'files' => true
                ]) }}
            @endif

            <fieldset class="content-group vue-link">

                <div class="form-group">
                    {{ Form::label('name', 'Abone Adı', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('email', 'E-Mail', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::email('email', old('email'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('created_at', 'Güncelleme Tarihi', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('created_at', old('phone'), ['class' => 'form-control', 'readonly']) }}
                        <span class="label label-danger">{{ $errors->first('created_at') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('active', 'Aktif', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="checkbox">
                            {!!  Form::checkbox2('active', '1', old('active'), ['class' => 'styled']) !!}
                        </div>
                    </div>
                </div>

            </fieldset>

            <div class="text-right">
                <button type="reset" class="btn btn-default" id="reset">Temizle <i class="icon-reload-alt position-right"></i></button>
                <button type="submit" class="btn btn-primary">Kaydet <i class="icon-arrow-right14 position-right"></i></button>
            </div>

            {{ Form::close() }}

        </div>
    </div>
    @endsection

    @section('js')
            <!-- Theme JS files -->
    <script type="text/javascript" src="/cms/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/tags/tagsinput.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/tags/tokenfield.min.js"></script>
    <script type="text/javascript" src="/cms/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jasny_bootstrap.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
    <script type="text/javascript" src="/cms/js/pages/form_inputs.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/uploaders/fileinput.min.js"></script>
    <script type="text/javascript" src="/cms/js/vue.min.js"></script>
    <!-- /theme JS files -->
    
@endsection
