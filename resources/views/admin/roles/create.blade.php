@extends('admin.layouts.master')
@section('title', 'Master CMS')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

            <!-- Page header -->
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kullanıcılar</span> /
                    @if(!isset($role)) Rol Ekle @else Rol Düzenle @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i><span>Rol Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="datatable_responsive.html">Kullanıcılar</a></li>
                <li class="active">@if(!isset($role)) Rol Ekle @else Rol Düzenle @endif</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')
    <!-- Form validation -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($role)) Rol Ekle @else Rol Düzenle @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <p class="content-group-lg">Kısa açıklama..</p>

            @if (!isset($role))
                {{ Form::open(['route' => 'admin.roles.store', 'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off']) }}
            @else
                {{ Form::model($role, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.roles.update', $role->id],
                  'method' => 'put'
                ]) }}
            @endif

                <fieldset class="content-group">

                    <!-- Basic text input -->
                    <div class="form-group">
                        {{ Form::label('name', 'Rol adı', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <!-- /basic text input -->

                    @foreach ($permissions as $per => $desc)
                    <!-- Single styled checkbox -->

                    <div class="form-group">
                        <label class="control-label col-lg-3">{{ $desc }}</label>
                        <div class="col-md-9">
                            <div class="checkbox checkbox-switchery switchery-xs">
                                <label>
                                    <input type="checkbox" name="permissions[]" class="switchery" value="{{ $per }}" {{ (@$role->permissions[$per]) ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /single styled checkbox -->
                    @endforeach
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
<script type="text/javascript" src="/cms/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/inputs/touchspin.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/styling/switch.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="/cms/js/core/app.js"></script>
<script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
<!-- /theme JS files -->
@endsection
