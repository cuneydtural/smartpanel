@extends('admin.layouts.master')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

            <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kampanya Yönetimi</span>
                    /@if(!isset($campaign)) Kampanya Ekle @else Kampanya Bilgileri @endif</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-link btn-float has-text"><i
                                class="icon-list text-primary"></i>
                        <span>Kampanya Listesi</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Anasayfa</a>
                </li>
                <li><a href="{{ route('admin.stores.index') }}">Kampanya Yönetimi</a></li>
                <li class="active">@if(!isset($campaign)) Kampanya Ekle @else Kampanya Bilgileri @endif</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')
            <!-- Form validation -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h5 class="panel-title">@if(!isset($campaign)) Kampanya Ekle @else Kampanya Bilgileri @endif</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            @if (!isset($campaign))
                {{ Form::open(['route' => ['admin.campaigns.store'],
                'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off', 'files' => true]) }}
            @else
                {{ Form::model($campaign, [
                  'class'     => 'form-horizontal form-validate-jquery',
                  'route'  => ['admin.campaigns.update', $campaign->id],
                  'method' => 'put',
                  'files' => true
                ]) }}
            @endif

            <fieldset class="content-group vue-app">

                <div class="form-group">
                    {{ Form::label('name', 'Kampanya Adı', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'required']) }}
                        <span class="label label-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('type', 'Kampanya Türü', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        @foreach(\App\Campaign::campaignType() as $key => $value)
                            <label class="radio-inline">
                                {{ Form::radio('type', $key, old('type'), ['class' => 'styled', 'v-model' => 'type']) }} {{ $value }}
                            </label><br>
                        @endforeach
                        <span class="label label-danger">{{ $errors->first('type') }}</span>
                    </div>
                </div>

                <div class="form-group" v-show="default">
                    {{ Form::label('discount', 'İndirim %', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('discount', old('discount'), ['class' => 'form-control spinner-basic', 'required']) }}
                        <span class="label label-danger">{{ $errors->first('discount') }}</span>
                    </div>
                </div>

                <div class="form-group" v-show="coupon">
                    {{ Form::label('coupon_keyword', 'Kupon Keyword', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        {{ Form::text('coupon_keyword', old('name'), ['class' => 'form-control']) }}
                        <span class="label label-danger">{{ $errors->first('coupon_keyword') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('date_start', 'Başlama Tarihi', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-icon" id="date-btn-1"><i
                                            class="icon-calendar3"></i></button>
                            </span>
                            {{ Form::text('date_start', old('date_start'), ['class' => 'form-control', 'id' => 'date-input-1', 'required']) }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('date_end', 'Bitiş Tarihi', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-icon" id="date-btn-2"><i
                                            class="icon-calendar3"></i></button>
                            </span>
                            {{ Form::text('date_end', old('date_end'), ['class' => 'form-control', 'id' => 'date-input-2', 'required']) }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('products', 'Ürün Seçiniz', ['class' => 'control-label col-lg-3']) }}
                    <div class="col-lg-9">
                        <select name="products[]" multiple="multiple" class="form-control listbox">
                            @foreach(\App\Product::all() as $product)
                                <option value="{{ $product->id }}"
                                @if(isset($campaign)) {{ (in_array($product->id, $campaign->products->pluck('id')->toArray()) ? 'selected' : '') }} @endif>
                                    {{ $product->name }}</option>
                            @endforeach
                        </select>
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
                <button type="reset" class="btn btn-default" id="reset">Temizle <i
                            class="icon-reload-alt position-right"></i></button>
                <button type="submit" class="btn btn-primary">Kaydet <i class="icon-arrow-right14 position-right"></i>
                </button>
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
    <script type="text/javascript" src="/cms/js/plugins/forms/tags/tagsinput.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/tags/tokenfield.min.js"></script>
    <script type="text/javascript" src="/cms/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jasny_bootstrap.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/inputs/duallistbox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/uploaders/fileinput.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jquery_ui/widgets.min.js"></script>
    <script type="text/javascript" src="/cms/js/vue.min.js"></script>
    <!-- /theme JS files -->

    <script>

        // Basic spinner
        $(".spinner-basic").spinner({
            min: 0,
        });

        new Vue({
            el: '.vue-app',
            data: {
                type: 1,
            },
            computed: {
                default: function(){
                    return this.type == 1;
                },
                coupon: function(){
                    return this.type == 2;
                },
            }
        });

        // Select with search
        $('.select-search').select2();

        // Basic example
        $('.listbox').bootstrapDualListbox();

        // Any Time Picker
        $('#date-btn-1').click(function (e) {
            $('#date-input-1').AnyTime_noPicker().AnyTime_picker().focus();
            e.preventDefault();
        });

        $('#date-btn-2').click(function (e) {
            $('#date-input-2').AnyTime_noPicker().AnyTime_picker().focus();
            e.preventDefault();
        });

    </script>

@endsection
