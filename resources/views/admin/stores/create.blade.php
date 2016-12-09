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
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Şube Yönetimi</span> /
                    @if(!isset($store)) Şube Ekle @else Şube Bilgileri @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.stores.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Şube Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.stores.index') }}">Şube Yönetimi</a></li>
                <li class="active">@if(!isset($store)) Şube Ekle @else Şube Bilgileri @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')
    <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($store)) Şube Ekle @else Şube Bilgileri @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            @if (!isset($store))
                {{ Form::open(['route' => ['admin.stores.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($store, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.stores.update', $store->id],
                  'method' => 'put',
                  'files' => true
                ]) }}
            @endif

            <fieldset class="content-group vue-link">

                <div class="form-group">
                    {{ Form::label('category', 'Kategori', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::select2('category', App\Store::categories(), old('type'), ['class' => 'select-search']) }}
                        <span class="label label-danger">{{ $errors->first('type') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('name', 'Şube Adı', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('address', 'Adres', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('address', old('address'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('address') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('name', 'İl / İlçe', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9 pad-0">
                        <div class="col-md-6">
                            {{ Form::select2('city', App\City::getCities(), old('city'), ['class' => 'select-search', 'id' => 'city']) }}
                            <span class="label label-danger">{{ $errors->first('city') }}</span>
                        </div>
                        <div class="col-md-6">
                            {{ Form::select2('district', (isset($store->city)) ? \App\District::getDistricts($store->city) : ['' => 'İlçe Seçiniz'], old('district'), ['class' => 'select-search', 'id' => 'district']) }}
                            <span class="label label-danger">{{ $errors->first('district') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('name', 'Konum (Latitude/Longitude)', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9 pad-0">
                        <div class="col-md-6">
                            {{ Form::text('lat', old('lat'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('lat') }}</span>
                        </div>
                        <div class="col-md-6">
                            {{ Form::text('lng', old('lng'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('lng') }}</span>
                        </div>
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
                    {{ Form::label('phone', 'Telefon', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'data-mask' => '0(999) 999 99 99']) }}
                        <span class="label label-danger">{{ $errors->first('title') }}</span>
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

    <script>
        $(function(){
            $('select[name="city"]').change(function(e){
                var val = e.target.value;
                if(val) {
                    $.get('/api/get-districts/' + val, function (data) {
                        $('#district').empty();
                        $.each(data, function (edit, subcatObj) {
                            $('#district').append('<option value="' + subcatObj.id + '">' + subcatObj.district + '</option>');
                        });
                    });
                } else {
                    $('#district').html('<option value="0">Şehir Seçiniz</option>');
                }
            });
        });

        // Select with search
        $('.select-search').select2();
    </script>

@endsection
