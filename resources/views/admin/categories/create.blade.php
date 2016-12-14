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
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kategoriler</span> /
                    @if(!isset($category)) Kategori Ekle @else Kategori Düzenle @endif</h4>
            </div>
"
            <div class="heading-elements">
                <div class="heading-btn-group">
                    @if(isset($category))
                    <a data-toggle="modal" data-target="#locale-lists" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Dil Listeleri</span></a>
                    <a data-toggle="modal" data-target="#create-locale" class="btn btn-link btn-float has-text"><i class="icon-plus2 text-primary"></i>
                        <span>Dil Ekle</span></a>
                    @endif
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-link btn-float has-text"><i class="icon-tree6 text-primary"></i>
                        <span>Kategoriler</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                @foreach ($breadcrumb as $bread)
                    <li> <a href="/admin/categories/{{ $bread->id }}">{{ $bread->name }}</a> </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    <!-- Dil Ekle -->
    <div id="create-locale" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-teal">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title"><i class="icon-camera position-left icon-1x"></i>Kategori Dil Ekleme</h6>
                </div>
                <div class="modal-body height-auto">
                </div>
            </div>
        </div>
    </div>
    <!-- /Dil Ekle -->

    <!-- Form validation -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($category)) Kategori Ekle @else Kategori Düzenle @endif</h5>
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

            @if (!isset($category))
                {{ Form::open(['route' => ['admin.categories.store', 'parent_id' => $parent_id],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off']) }}
            @else
                {{ Form::model($category, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.categories.update', $category->id],
                  'method' => 'put'
                ]) }}
            @endif

                <fieldset class="content-group vue-link">

                    <div class="form-group">
                        {{ Form::label('name', 'Kategori Adı', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-8">
                            {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('link_type', 'Bağlantı Tipi', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-8">
                            @foreach(\App\Category::linkType() as $key => $value)
                                <label class="radio-inline">
                                    {{ Form::radio('link_type', $key, old('link_type'), ['class' => 'styled', 'v-model' => 'url_type']) }} {{ $value }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group" v-show="default">
                        {{ Form::label('url', 'Bağlantı Yolu', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-8">
                            {{ Form::text('url', old('url'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('url') }}</span>
                        </div>
                    </div>

                    <div class="form-group" v-show="articles">
                        {{ Form::label('article_url', 'Yazı Seç', ['class' => 'control-label col-lg-3']) }}
                        <div class="col-lg-8">
                            {{ Form::select2('article_url', \App\Article::getArticles(), old('article_url'), ['class' => 'select-search']) }}
                            <span class="label label-danger">{{ $errors->first('article_url') }}</span>
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
<script type="text/javascript" src="/cms/js/core/libraries/jquery_ui/interactions.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/cms/js/core/app.js"></script>
<script type="text/javascript" src="/cms/js/vue.min.js"></script>
<script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
<!-- /theme JS files -->

    <script>
        $(function(){

            // Select with search
            $('.select-search').select2();

            @if (isset($category))
            $('#locale-lists').on('show.bs.modal', function() {
                $(this).find('.modal-body').load('{{ route('admin.categories.locale.index', ['id' => $category->id]) }}')
            }).on('shown.bs.modal', function() {
                $( ".edit-locale" ).click(function() {
                    var id = $(this).attr("data-id");
                    var url = '{{ url('/admin/categories/locale/edit/') }}/'+id;
                    $('#create-locale').modal('show');
                    $("#create-locale").find('.modal-body').load(url);
                });
            });
                $('#create-locale').on('show.bs.modal', function() {
                $(this).find('.modal-body').load('{{route('admin.categories.locale.create', ['id' => $category->id]) }}')
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
    </script>
@endsection
