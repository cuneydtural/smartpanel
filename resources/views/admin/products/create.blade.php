@extends('admin.layouts.master')
@section('title', 'Smart Panel')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

            <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürün Yönetimi</span> /
                    @if(!isset($product)) Ürün Ekle @else Ürün Bilgileri @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-link btn-float has-text"><i class="icon-list text-primary"></i>
                        <span>Ürün Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="{{ route('admin.products.index') }}">Ürün Yönetimi</a></li>
                <li class="active">@if(!isset($product)) Ürün Ekle @else Ürün Bilgileri @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    @include('admin.includes.choose_modal')

    <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($product)) Ürün Ekle @else Ürün Bilgileri @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            @if (!isset($product))
                {{ Form::open(['route' => ['admin.products.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($product, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.products.update', $product->id],
                  'method' => 'put',
                  'files' => true
                ]) }}
            @endif

            <fieldset class="content-group vue-link">

                <div class="form-group">
                    {{ Form::label('category_id', 'Kategori', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::select2('category_id', \App\Category::getProductCategories(), old('category_id'), ['class' => 'select-search']) }}
                        <span class="label label-danger">{{ $errors->first('category_id') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('brand_id', 'Marka', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::select2('brand_id', \App\Category::getBrands(), old('brand_id'), ['class' => 'select-search']) }}
                        <span class="label label-danger">{{ $errors->first('brand_id') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('name', 'Ürün Adı', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('keywords', 'Anahtar Kelimeler', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('keywords', old('keywords'), ['class' => 'form-control tags-input']) }}
                        <span class="label label-danger">{{ $errors->first('keywords') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('desc', 'Kısa Açıklama', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::textarea('desc', old('desc'), ['class' => 'form-control textarea-style']) }}
                        <span class="label label-danger">{{ $errors->first('desc') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('image', 'Fotoğraf Yükle', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="image[]" type="file" class="file-input" multiple="true" data-show-preview="false">
                                <span class="help-block">Çoklu fotoğraf yüklemek için birden fazla fotoğraf seçebilirsiniz.
                                    @if(!isset($product)) Kütüphaneden fotoğraf seçebilmek yazıyı kaydetmelisiniz. @endif</span>
                            </div>
                            @if(isset($product))
                                <div class="col-md-6"> <a class="btn bg-teal" data-toggle="modal" data-target="#choose-photo">Kütüphane'den Seç <i class="icon-camera position-right"></i></a></div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('content', 'İçerik', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::textarea('content', old('content'), ['id' => 'editor-full']) }}
                        <span class="label label-danger">{{ $errors->first('content') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('price', 'Tutar', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('price', old('price'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('price') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('discount', 'İndirim Oranı %', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('discount', old('discount'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('discount') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('quantity', 'Stok Adedi', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9 pad-0">
                        <div class="col-md-6">
                            {{ Form::text('quantity', old('quantity'), ['class' => 'form-control']) }}
                            <span class="label label-danger">{{ $errors->first('quantity') }}</span>
                        </div>
                        <div class="col-md-6">
                            {{ Form::select2('quantity_type', \App\Http\Controllers\ListController::quantityTypes(), old('quantity_type'), ['class' => 'select-search']) }}
                            <span class="label label-danger">{{ $errors->first('quantity_type') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('barcode', 'Barkod No', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('barcode', old('barcode'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('barcode') }}</span>
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('vat_included', 'Fiyata KDV Dahil', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="checkbox">
                            {!!  Form::checkbox2('vat_included', '1', (isset($product) ? old('vat_included') : 1), ['class' => 'styled']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('installment', 'Taksit yapılsın mı ?', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="checkbox">
                            {!!  Form::checkbox2('installment', '1', (isset($product) ? old('installment') : 1), ['class' => 'styled']) !!}
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

    <div class="col-md-12 pad-0">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h5 class="panel-title">Fotoğraflar
                    @if(isset($product->photos))
                        <strong>({{ count($product->photos) }})</strong>
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
                    @if(isset($product->photos))
                        <div class="col-md-12 pad-0">
                            @foreach($product->photos as $photos)
                                <div class="col-lg-2 col-sm-4 col-md-3">
                                    <div class="thumbnail">
                                        <div class="thumb">
                                            <img src="/{{ $photos->thumb_path.$photos->name }}" alt="">
                                            <div class="caption-overflow">
										<span>
											<a href="/{{ $photos->path.$photos->name }}" data-popup="lightbox" rel="gallery"
                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-search4"></i></a>
											<a href="#" data-photo-id="{{ $photos->id }}" data-product-id="{{ $product->id }}" class="remove-photo btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-cross2"></i></a>
                                            <a href="{{ route('admin.articles.showcase.set', ['id' => $photos->pivot->id, 'source_id' => $product->id]) }}" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-star-full2"></i></a>
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
                            Bu ürüne henüz fotoğraf eklenmemiştir!
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
    <!-- /theme JS files -->

    <script>

        $(function(){

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
            @if(isset($product))
            $('#choose-photo').on('show.bs.modal', function() {
                $(this).find('.modal-body').load('{{ route('admin.choose.library') }}', function() {
                });
            }).on('shown.bs.modal', function() {
                $(".datatable-responsive").on("click", ".choose-btn", function (e) {
                    var file_id = $(this).attr("data-id");
                    var product_id = '{{ $product->id }}';
                    $.ajax({
                        url : "{{ route('admin.products.ajax') }}",
                        type: "POST",
                        data : {file_id: file_id, product_id: product_id},
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

            var product_id = $(this).data("product-id");
            var photo_id = $(this).data("photo-id");

            bootbox.confirm("Fotoğraf siliniyor onaylıyor musunuz?", function (result) {
                if (result == true) {
                    $.ajax({
                        url: '{{ route('admin.products.photo.delete') }}',
                        data: {product_id: product_id, photo_id: photo_id},
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
