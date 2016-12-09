@extends('admin.layouts.master')
@section('title', 'Master CMS')

@section('css')
<link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
<link href="/cms/css/croppic.css" rel="stylesheet" type="text/css">
@endsection

@section('page-header')

<!-- Page header -->
<div class="page-header">
<div class="page-header-content">
    <div class="page-title">
        <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Üyeler</span> /
            @if(!isset($user)) Üye Ekle @else Üye Düzenle @endif</h4>
    </div>

    <div class="heading-elements">
        <div class="heading-btn-group">
            <a href="{{ route('admin.users.index') }}" class="btn btn-link btn-float has-text">
                <i class="icon-list text-primary"></i><span>Kullanıcı Listesi</span></a>
        </div>
    </div>
</div>

<div class="breadcrumb-line breadcrumb-line-component bg-grey">
    <ul class="breadcrumb">
        <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
        <li><a href="datatable_responsive.html">Üyeler</a></li>
        <li class="active">@if(!isset($user)) Üye Ekle @else Üye Düzenle @endif</li>
    </ul>

    <ul class="breadcrumb-elements">
        <li><a href="#"><i class="icon-comment-discussion position-left"></i> Hata Bildir</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-gear position-left"></i>
                Filtrele
                <span class="caret"></span>
            </a>

            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#"><i class="icon-user-lock"></i> Sıralamaya Göre</a></li>
                <li><a href="#"><i class="icon-statistics"></i> ID'ye göre</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
            </ul>
        </li>
    </ul>
</div>
</div>
<!-- /page header -->
@endsection

@section('content')
<!-- Form validation -->
<div class="panel panel-flat">
<div class="panel-heading">
    <h5 class="panel-title">@if(!isset($user)) Üye Ekle @else Üye Düzenle @endif</h5>
    <div class="heading-elements">
        <ul class="icons-list">
            <li><a data-action="collapse"></a></li>
            <li><a data-action="reload"></a></li>
            <li><a data-action="close"></a></li>
        </ul>
    </div>
</div>

<div class="panel-body">

    @if (!isset($user))
        {{ Form::open(['route' => 'admin.users.store', 'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off']) }}
    @else
        {{ Form::model($user, [
          'class'     => 'form-horizontal form-validate-jquery',
          'route'  => ['admin.users.update', $user->id],
          'method' => 'put'
        ]) }}
    @endif

    <div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="active"><a href="#colored-nav-tab1" data-toggle="tab">Üye Bilgileri</a></li>
            <li><a href="#colored-nav-tab2" data-toggle="tab">Yetkiler</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane has-padding active" id="colored-nav-tab1">
                    <div class="col-md-6">
                        <fieldset class="content-group">

                            <div class="form-group">
                                {{ Form::label('image', 'Profil Fotoğrafı', ['class' => 'control-label col-lg-3']) }}
                                <div class="col-lg-9">
                                    <div id="cropContainerModal">
                                        @if(isset($user))
                                            <img src="{{url('/photos/crop/'.$user->image.'')}}">
                                        @endif
                                    </div>
                                    {{ Form::hidden('image', null, ['id' => 'cropOutput']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('first_name', 'Adı', ['class' => 'control-label col-lg-3']) }}
                                <div class="col-lg-9">
                                    {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'required']) }}
                                    <span class="label label-danger">{{ $errors->first('first_name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('last_name', 'Soyadı', ['class' => 'control-label col-lg-3']) }}
                                <div class="col-lg-9">
                                    {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'required']) }}
                                    <span class="label label-danger">{{ $errors->first('last_name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('email', 'E-Mail', ['class' => 'control-label col-lg-3']) }}
                                <div class="col-lg-9">
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'required']) }}
                                    <span class="label label-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('password', 'Şifre', ['class' => 'control-label col-lg-3']) }}
                                <div class="col-lg-9">
                                    @if (isset($user))
                                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Değiştirilmeyecekse boş bırakınız.']) }}
                                    @else
                                        {{ Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Şifrenizi belirleyin (En az 6 karakter)']) }}
                                    @endif
                                    <span class="label label-danger">{{ $errors->first('password') }}</span>
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
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <!-- Daily sales -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Hesaba Bağlı Roller</h6>
                            </div>

                            <div class="panel-body">
                                <div id="sales-heatmap">Seçili rollerin tüm yetkileri kullanıcaya atanacaktır.</div>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="media-left media-middle"><span class="label bg-blue">{{$role->id}}</span></div>
                                            <div class="media-body">
                                                <div class="media-heading"><a href="#" class="letter-icon-title">{{$role->name}}</a></div>
                                                <div class="text-muted text-size-small"><i class="icon-checkmark3 text-size-mini position-left"></i> {{$role->created_at}}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted text-size-small">
                                                 <div class="checkbox checkbox-switchery switchery-xs">
                                                     <label>
                                                        <input type="checkbox" name="roles[]" class="switchery"
                                                               value="{{ $role->id }}" {{ (isset($user) && $user->hasRole($role->id)) ? 'checked' : '' }}>
                                                     </label>
                                                 </div>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /daily sales -->
                    </div>
            </div>
            <div class="tab-pane has-padding" id="colored-nav-tab2">
                <!-- Solid thead border -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Kullanıcı Yetkileri</h5>
                    </div>
                    <div class="panel-body">Kullanıcıya vermek istediğiniz yetkiyi işaretleyiniz.</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr class="border-solid">
                                <th>#</th>
                                <th>Yetki</th>
                                <th>Grup'dan Gelen Yetki</th>
                                <th>Kullanıcı Yetkisi</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $count = 1; ?>
                            @foreach($permissions as $perm => $aciklama)
                            <tr>
                                <td><span class="label bg-blue">{{ $count++ }}</span></td>
                                <td>{{ $aciklama }}
                                </td>
                                <th>
                                    {!! ( isset($user) && @array_key_exists($perm, $user->getRolesPermissions()) &&
                      $user->getRolesPermissions()[$perm] == 1 ) ? '<i class="icon-checkmark4 color-green"></i>' : '<i class="icon-cross2 color-red"></i>' !!}
                                </th>
                                <td>
                                    <div class="checkbox checkbox-switchery switchery-xs">
                                        <label>
                                            <input type="checkbox" name="permissions[]" class="switchery"
                                                   value="{{ $perm }}" {{ (isset($user) && array_key_exists($perm, $user->permissions) && $user->permissions[$perm] == true) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /solid thead border -->
            </div>
        </div>

        <div class="row button-fix">
            <div class="text-right">
                <button type="reset" class="btn btn-default" id="reset">Temizle <i class="icon-reload-alt position-right"></i></button>
                <button type="submit" class="btn btn-primary">Kaydet <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>

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
<script type="text/javascript" src="/cms/js/croppic.js"></script>
<!-- /theme JS files -->

    <script>

        var croppicContainerModalOptions = {
            uploadUrl: '{{ route('api.croppic.upload') }}',
            cropUrl: '{{ route('api.croppic.crop') }}',
            modal: true,
            zoomFactor:10,
            rotateControls: false,
            doubleZoomControls:true,
            enableMousescroll:true,
            outputUrlId: 'cropOutput',
            imgEyecandy:false,
            imgEyecandyOpacity: 0.5,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span>' +
            '<span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            uploadData:{ "title":" @if(isset($user)) {{ $user->first_name.' '.$user->last_name }} @else crop @endif "}
        }
        var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);

    </script>
@endsection