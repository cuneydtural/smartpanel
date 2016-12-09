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
        <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ayarlar</span> / Düzenle</h4>
    </div>

    <div class="heading-elements">
        <div class="heading-btn-group">
            <a href="{{ route('admin.git.update') }}" class="btn btn-link btn-float has-text">
                <i class="icon-github text-primary"></i><span>Yazılım Güncelle</span></a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-link btn-float has-text">
                <i class="icon-plus3 text-primary"></i><span>Yeni Kullanıcı Ekle</span></a>
        </div>
    </div>
</div>

<div class="breadcrumb-line breadcrumb-line-component bg-grey">
    <ul class="breadcrumb">
        <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
        <li><a href="datatable_responsive.html">Ayarlar</a></li>
        <li class="active">Düzenle</li>
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
    <h5 class="panel-title">Ayar Düzenleme</h5>
    <div class="heading-elements">
        <ul class="icons-list">
            <li><a data-action="collapse"></a></li>
            <li><a data-action="reload"></a></li>
            <li><a data-action="close"></a></li>
        </ul>
    </div>
</div>

<div class="panel-body">

    {{ Form::model($settings, [
         'class'     => 'form-horizontal form-validate-jquery',
         'route'  => ['admin.settings.update', $settings->id],
         'method' => 'put',
         'files' => true
       ]) }}

    <div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="active"><a href="#colored-nav-tab1" data-toggle="tab"><i class="icon-cogs position-left"></i> Genel Ayarlar</a></li>
            <li><a href="#colored-nav-tab2" data-toggle="tab"><i class="icon-code position-left"></i> Javascript & Meta Kodları</a></li>
            <li><a href="#colored-nav-tab3" data-toggle="tab"><i class="icon-bubbles position-left"></i> Sosyal Medya Hesapları</a></li>
            <li><a href="#colored-nav-tab4" data-toggle="tab"><i class="icon-mention position-left"></i> Form Mail Ayarları</a></li>
            <li><a href="#colored-nav-tab5" data-toggle="tab"><i class="icon-image3 position-left"></i> Fotoğraf Ayarları</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane has-padding active" id="colored-nav-tab1" style="margin-top:20px !important;">
                <fieldset class="content-group">

                    <div class="form-group">
                        {{ Form::label('site_name', 'Site Adı', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('site_name', old('site_name'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('site_name') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('logo', 'Logo', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            <div class="image-load">
                                @if ($settings->logo)
                                    <img src="/photos/{{ $settings->logo }}" width="100%">
                                @else
                                    <img src="/cms/images/no-photo.jpg" width="100%">
                                @endif
                            </div>
                            {{ Form::file('image', ['class' => 'file-styled-primary', 'id' => 'image-select']) }}
                            <span class="label label-danger">{{ $errors->first('image') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('title', 'Başlık (Title)', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('title', old('title'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('desc', 'Açıklama (Description)', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('desc', old('title'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('desc') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('keywords', 'Anahtar Kelimeler (Keywords)', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('keywords', old('keywords'), ['class' => 'form-control tags-input']) }}
                            <span class="label label-danger">{{ $errors->first('keywords') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('url', 'Site URL', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('url', old('url'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('url') }}</span>
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- genel bilgiler -->

            <div class="tab-pane has-padding" id="colored-nav-tab2">
                <fieldset class="content-group">
                    <div class="form-group">
                        {{ Form::label('code_google', 'Google', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::textarea('code_google', old('code_google'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('code_google') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('code_yandex', 'Yandex', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::textarea('code_yandex', old('code_yandex'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('code_yandex') }}</span>
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- Javascript & Meta kodları -->

            <div class="tab-pane has-padding" id="colored-nav-tab3">
                <fieldset class="content-group">

                    <div class="form-group">
                        {{ Form::label('facebook_url', 'Facebook', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                {{ Form::text('facebook_url', old('facebook_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('facebook_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('twitter_url', 'Twitter', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                {{ Form::text('twitter_url', old('twitter_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('twitter_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('googleplus_url', 'Google Plus', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                                {{ Form::text('googleplus_url', old('googleplus_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('googleplus_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('youtube_url', 'Youtube', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                {{ Form::text('youtube_url', old('youtube_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('youtube_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('linkedin_url', 'Linkedin', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                {{ Form::text('linkedin_url', old('linkedin_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('linkedin_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('instagram_url', 'Instagram', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                {{ Form::text('instagram_url', old('instagram_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('instagram_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('swarm_url', 'Swarm', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                {{ Form::text('swarm_url', old('swarm_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('swarm_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('foursquare_url', 'Foursquare', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-foursquare"></i></span>
                                {{ Form::text('foursquare_url', old('foursquare_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('foursquare_url') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('pinterest_url', 'Pinterest', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
                                {{ Form::text('pinterest_url', old('pinterest_url'), ['class' => 'form-control']) }}
                                <span class="label label-danger">{{ $errors->first('pinterest_url') }}</span>
                            </div>
                        </div>
                    </div>


                </fieldset>
            </div>
            <!-- sosyal medya hesapları -->

            <div class="tab-pane has-padding" id="colored-nav-tab4">
                <fieldset class="content-group">

                    <div class="form-group">
                        {{ Form::label('mail_driver', 'Mail Driver', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_driver', old('mail_driver'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_driver') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_address', 'E-Mail', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_address', old('mail_address'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_address') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_host', 'Mail Host', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_host', old('mail_host'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_host') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_user', 'Kullanıcı Adı', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_user', old('mail_user'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_user') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_password', 'Şifre', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::password('mail_password', ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_password') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_port', 'Port', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_port', old('mail_port'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_port') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mail_to', 'Alıcı Mail', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('mail_to', old('mail_to'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('mail_to') }}</span>
                        </div>
                    </div>

                </fieldset>
            </div>
            <!-- Form mail ayarları -->

            <div class="tab-pane has-padding" id="colored-nav-tab5">
                <fieldset class="content-group">
                    <div class="col-md-6">

                        <div class="form-group">
                            {{ Form::label('slide', 'Slide (Boyutlar)', ['class' => 'control-label col-lg-3']) }}
                            <div class="col-lg-9">
                                <div class="col-md-6">
                                    {{ Form::text('slide_w', old('slide_w'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('slide_w') }}</span>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::text('slide_h', old('slide_h'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('slide_h') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('slide', 'Thumb (Boyutlar)', ['class' => 'control-label col-lg-3']) }}
                            <div class="col-lg-9">
                                <div class="col-md-6">
                                    {{ Form::text('thumb_w', old('thumb_w'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('thumb_w') }}</span>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::text('thumb_h', old('thumb_h'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('thumb_h') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('slide', 'Blog (Boyutlar)', ['class' => 'control-label col-lg-3']) }}
                            <div class="col-lg-9">
                                <div class="col-md-6">
                                    {{ Form::text('blog_w', old('blog_w'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('blog_w') }}</span>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::text('blog_h', old('blog_h'), ['class' => 'form-control']) }}
                                    <span class="label label-danger">{{ $errors->first('blog_h') }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>
            <!-- Fotoğraf Ayarları -->
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
<script type="text/javascript" src="/cms/js/plugins/forms/tags/tagsinput.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="/cms/js/core/app.js"></script>
<script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
<script type="text/javascript" src="/cms/js/pages/form_inputs.js"></script>
<script type="text/javascript" src="/cms/js/load-image.js"></script>
<!-- /theme JS files -->

    <script>

        $(function() {
            $('.tags-input').tagsinput();
            $('#image-select').change(function (e) {
                loadImage(
                        e.target.files[0],
                        function (prevIMG) {
                            $(".image-load").html(prevIMG);
                        },
                        {maxWidth: 200, maxHeight: 140}
                );
            });
            // prev image
        });

    </script>
@endsection

