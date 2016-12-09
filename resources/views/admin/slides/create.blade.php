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
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Slide Yönetimi</span> /
                    @if(!isset($slide)) Slide Ekle @else Slide Düzenle @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.slides.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Slide Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.slides.index') }}">Slide Yönetimi</a></li>
                <li class="active">@if(!isset($slide)) Slide Ekle @else Slide Düzenle @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    <!-- Choose Modal -->
    @include('admin.includes.choose_modal')
    <!-- /Choose Modal -->

    <!-- Form validation -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($slide)) Slide Ekle @else Slide Düzenle @endif</h5>
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

            @if (!isset($slide))
                {{ Form::open(['route' => ['admin.slides.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($slide, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.slides.update', $slide->id],
                  'method' => 'put',
                  'files' => true
                ]) }}
            @endif

                <fieldset class="content-group vue-link">

                    <div class="form-group">
                        {{ Form::label('title', 'Başlık', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('title', old('title'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('desc', 'Kısa Açıklama', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('desc', old('desc'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('desc') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('url_type', 'Bağlantı Tipi', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            @foreach(\App\Slide::urlType() as $key => $value)
                                <label class="radio-inline">
                                    {{ Form::radio('url_type', $key, old('link_type'), ['class' => 'styled', 'v-model' => 'url_type']) }} {{ $value }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group" v-show="default" style="display: none;">
                        {{ Form::label('url', 'Bağlantı Yolu', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('url', old('url'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('url') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('style_class', 'Yazılar Style Class', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            {{ Form::text('style_class', old('title'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('style_class') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('photo', 'Fotoğraf', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="image-load margin-left-10">
                                    @if (isset($slide->photo))
                                        <img src="/photos/thumbs/{{ $slide->photo }}">
                                    @else
                                        <img src="/cms/images/no-photo.jpg" width="100%">
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::file('image', ['class' => 'file-styled-primary', 'id' => 'image-select']) }}</div>
                                @if (isset($slide))
                                <div class="col-md-6"> <a href="#" class="btn bg-teal" data-toggle="modal" data-target="#choose-photo">Kütüphane'den Seç <i class="icon-camera position-right"></i></a></div>
                                @endif
                            </div>
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
<script type="text/javascript" src="/cms/js/vue.min.js"></script>
<script type="text/javascript" src="/cms/js/load-image.js"></script>

    <script>

        $(function(){
            new Vue({
                el: '.vue-link',
                data: {
                    url_type: null,
                },
                computed: {
                    default: function(){
                        return this.url_type.startsWith("2")
                    },
                }
            });

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

            @if(isset($slide))
            $('#choose-photo').on('show.bs.modal', function() {
                $(this).find('.modal-body').load('{{ route('admin.choose.library') }}', function() {
                });
            }).on('shown.bs.modal', function() {
                $(".datatable-responsive").on("click", ".choose-btn", function (e) {
                    var file_id = $(this).attr("data-id");
                    var file_name = $(this).attr("data-url");
                    var slide_id = '{{ $slide->id }}';

                    $.ajax({
                        url : "{{ route('admin.slides.ajax') }}",
                        type: "POST",
                        data : {file_id: file_id, file_name: file_name, slide_id: slide_id},
                        success: function(response)
                        {
                            swal({
                                title: "Fotoğraf seçildi!",
                                confirmButtonColor: "#66BB6A",
                                type: 'success'
                            }, function () {
                                location.reload();
                            });
                        },
                        error: function ()
                        {
                            swal({
                                title: "Fotoğraf seçilemedi!",
                                confirmButtonColor: "#66BB6A",
                                type: 'error'
                            }, function () {
                                location.reload();
                            });
                        }
                    });
                });
            }).on('hide.bs.modal', function() {
                location.reload();
            }).on('hidden.bs.modal', function() {
                location.reload();
            });
            @endif
        });
    </script>
<!-- /theme JS files -->
@endsection
