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
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Yazılar</span> /
                    @if(!isset($article)) Yazı Ekle @else Yazı Düzenle @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    @if(isset($article))
                        <a href="#" class="btn btn-link btn-float has-text"><i class="icon-screen3 text-primary"></i><span>Önizleme</span></a>
                    @endif
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i><span>Yazılar</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.articles.index') }}">Yazılar</a></li>
                <li class="active">@if(!isset($article)) Yazı Ekle @else Yazı Düzenle @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    <!-- Choose Modal -->
    @include('admin.includes.choose_modal')
    <!-- /Choose Modal -->
    @if (!isset($article))
    <div class="alert alert-info alert-styled-left alert-bordered">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Lütfen </span> tüm alanları eksiksiz olarak doldurunuz.
    </div>
    @endif

    <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($article)) Yazı Ekle @else Yazı Düzenle @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <p class="content-group-lg">Kısa açıklama</p>

            @if (!isset($article))
                {{ Form::open(['route' => ['admin.articles.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($article, [
                  'class' => 'form-horizontal form-validate-jquery', 'route'  => ['admin.articles.update', $article->id], 'method' => 'put', 'files' => true
                ]) }}
            @endif

            <fieldset class="content-group vue-link">

                <div class="form-group">
                    {{ Form::label('category', 'Kategori', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::select2('category', \App\Category::getArticleCategories(), old('category'), ['class' => 'select-search']) }}
                        <span class="label label-danger">{{ $errors->first('category') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('date', 'Tarih', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-calendar3"></i></span>
                            {{ Form::text('date', old('date'), ['class' => 'form-control', 'data-mask' => '99/99/9999']) }}
                        </div>
                        <span class="label label-danger">{{ $errors->first('date') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('title', 'Başlık', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::text('title', old('title'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('title') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('keywords', 'Anahtar Kelimeler', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::text('keywords', old('keywords'), ['class' => 'form-control tags-input']) }}
                        <span class="label label-danger">{{ $errors->first('keywords') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('desc', 'Kısa Açıklama', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::textarea('desc', old('desc'), ['class' => 'form-control textarea-style']) }}
                        <span class="label label-danger">{{ $errors->first('desc') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('content', 'Fotoğraf Yükle', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="image[]" type="file" class="file-input" multiple="true" data-show-preview="false">
                                <span class="help-block">Çoklu fotoğraf yüklemek için birden fazla fotoğraf seçebilirsiniz.
                                @if(!isset($article)) Kütüphaneden fotoğraf seçebilmek yazıyı kaydetmelisiniz. @endif</span>
                            </div>
                            @if(isset($article))
                            <div class="col-md-6"> <a class="btn bg-teal" data-toggle="modal" data-target="#choose-photo">Kütüphane'den Seç <i class="icon-camera position-right"></i></a></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('content', 'İçerik', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::textarea('content', old('content'), ['id' => 'editor-full']) }}
                        <span class="label label-danger">{{ $errors->first('content') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('link_type', 'Bağlantı Tipi', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        @foreach(\App\Category::linkType() as $key => $value)
                            <label class="radio-inline">
                                {{ Form::radio('link_type', $key, old('link_type'), ['class' => 'styled', 'v-model' => 'url_type']) }} {{ $value }}
                            </label><br>
                        @endforeach
                    </div>
                </div>

                <div class="form-group" v-show="default">
                    {{ Form::label('url', 'Bağlantı Yolu', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::text('url', old('url'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('url') }}</span>
                    </div>
                </div>

                <div class="form-group" v-show="articles">
                    {{ Form::label('article_url', 'Yazı Seç', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        {{ Form::select2('article_url', \App\Article::getArticles(), old('article_url'), ['class' => 'select-search']) }}
                        <span class="label label-danger">{{ $errors->first('article_url') }}</span>
                    </div>
                </div>

                @if (isset($article))
                    <div class="form-group">
                        {{ Form::label('permalink', 'Kalıcı bağlantı', ['class' => 'control-label col-lg-2']) }}
                        <div class="col-lg-10">
                            {{ Form::text('permalink', url(\App\Article::getLocaleCategorySlug($article).'/'.$article->slug), ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    {{ Form::label('slug_update', 'Kalıcı bağlantı güncellensin mi ?', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
                        <div class="checkbox">
                            {!!  Form::checkbox2('slug_update', '1', old('slug_update'), ['class' => 'styled']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('active', 'Aktif', ['class' => 'control-label col-lg-2']) }}
                    <div class="col-lg-10">
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

    <div class="col-md-12 pad-0">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h5 class="panel-title">Fotoğraflar
                    @if(isset($article->photos))
                        <strong>({{ count($article->photos) }})</strong>
                    @else
                        <strong>(0)</strong>
                    @endif
                </h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12 pad-0">
                    @if(isset($article->photos))
                    <div class="col-md-12 pad-0">
                        @foreach($article->photos as $photos)
                        <div class="col-lg-2 col-sm-4 col-md-3">
                            <div class="thumbnail">
                                <div class="thumb">
                                    <img src="/{{ $photos->thumb_path.$photos->name }}" alt="">
                                    <div class="caption-overflow">
										<span>
											<a href="/{{ $photos->path.$photos->name }}" data-popup="lightbox" rel="gallery"
                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-search4"></i></a>
											<a href="#" data-photo-id="{{ $photos->id }}" data-article-id="{{ $article->id }}" class="remove-photo btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-cross2"></i></a>
                                            <a href="{{ route('admin.articles.showcase.set', ['id' => $photos->pivot->id, 'source_id' => $article->id]) }}" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-star-full2"></i></a>
										</span>
                                    </div>
                                </div>
                                <div class="caption">
                                    <h6 class="no-margin">
                                        @if($photos->pivot->showcase)
                                            <span class="label label-primary">{{ $photos->mime }}</span>
                                            <span class="label label-success">VITRIN</span>
                                            <i class="icon-star-full2 pull-right text-primary-600"></i>
                                        @else <span class="label label-primary">{{ $photos->mime }}</span> @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-warning alert-styled-left">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            Bu yazıya henüz fotoğraf eklenmemiştir!
                        </div>
                    @endif
                </div>
            </div>
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

        $(function() {

            // Fancybox
            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });

            // Select with search
            $('.select-search').select2();

            $('.tags-input').tagsinput();

            // Full featured editor
            CKEDITOR.replace( 'editor-full', {
                height: '400px',
                extraPlugins: 'forms'
            });

            // Kütüphaneden fotoğraf seç
            @if(isset($article))
            $('#choose-photo').on('show.bs.modal', function() {
                $(this).find('.modal-body').load('{{ route('admin.choose.library') }}', function() {
                });
            }).on('shown.bs.modal', function() {
                $(".datatable-responsive").on("click", ".choose-btn", function (e) {
                    var file_id = $(this).attr("data-id");
                    var article_id = '{{ $article->id }}';
                    $.ajax({
                        url : "{{ route('admin.articles.ajax') }}",
                        type: "POST",
                        data : {file_id: file_id, article_id: article_id},
                        success: function(result)
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

            new Vue({
                el: '.vue-link',
                data: {
                    url_type: null,
                },
                computed: {
                    default: function(){
                        return this.url_type.startsWith("2")
                    },
                    articles: function(){
                        return this.url_type.startsWith("3")
                    },
                }
            });

        });

        // Image Upload
        $('.file-input').fileinput({
            browseLabel: 'Gözat',
            showUpload: true,
            browseIcon: '<i class="icon-file-plus"></i>',
            uploadIcon: '<i class="icon-file-upload2"></i>',
            uploadLabel: 'Yükle',
            removeIcon: '<i class="icon-cross3"></i>',
            removeLabel: 'Sil',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>'
            },
            initialCaption: "No file selected",
            uploadExtraData: {
                img_key: "1000",
                img_keywords: "happy, nature",
            }
        });

        $( ".remove-photo" ).click(function() {

            var article_id = $(this).data("article-id");
            var photo_id = $(this).data("photo-id");

            bootbox.confirm("Fotoğraf siliniyor onaylıyor musunuz?", function (result) {
                if (result == true) {
                    $.ajax({
                        url: '{{ route('admin.articles.photo.delete') }}',
                        data: {article_id: article_id, photo_id: photo_id},
                        type: 'POST',
                        success: function (result) {
                            console.log(result);
                            location.reload();
                        }
                    });
                }
            });

        });

    </script>

@endsection
