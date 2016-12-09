<div class="panel-body">
    <p class="content-group-lg">Lütfen ilgili kategoriye eklemek istediğiniz dili seçin!</p>

    @if (!isset($category))
        {{ Form::open(['route' => ['admin.categories.locale.store', 'id' => $id],
        'class' => 'form-horizontal form-validate-jquery', 'autocomplete'=>'off']) }}
    @else
        {{ Form::model($category, [
          'class'     => 'form-horizontal form-validate-jquery',
          'route'  => ['admin.categories.locale.update', $category->id],
          'method' => 'put'
        ]) }}
    @endif

    <fieldset class="content-group vue-link">

        {{ Form::hidden('category_id', $id, ['class' => 'form-control']) }}

        <div class="form-group">
            {{ Form::label('locale', 'Dil', ['class' => 'control-label col-lg-3']) }}
            <div class="col-lg-9">
                {{ Form::select2('locale', \App\Helpers\Helper::getLanguages(), old('category')) }}
                <span class="label label-danger">{{ $errors->first('locale') }}</span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('name', 'Kategori Adı', ['class' => 'control-label col-lg-3']) }}
            <div class="col-lg-9">
                {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                <span class="label label-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('link_type', 'Bağlantı Tipi', ['class' => 'control-label col-lg-3']) }}
            <div class="col-lg-9">
                @foreach(\App\Category::linkType() as $key => $value)
                    <label class="radio-inline">
                        {{ Form::radio('link_type', $key, old('link_type'), ['class' => 'styled', 'v-model' => 'url_type']) }} {{ $value }}
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

        <div class="form-group" v-show="articles">
            {{ Form::label('article_url', 'Yazı Seç', ['class' => 'control-label col-lg-3']) }}
            <div class="col-lg-8">
                {{ Form::select2('article_url', \App\Article::getArticles(), old('article_url'), ['class' => 'select-search']) }}
                <span class="label label-danger">{{ $errors->first('article_url') }}</span>
            </div>
        </div>

    </fieldset>

    <div class="text-right">
        <button type="reset" class="btn btn-default" id="reset">Temizle <i class="icon-reload-alt position-right"></i></button>
        <button type="submit" class="btn btn-primary">Kaydet <i class="icon-arrow-right14 position-right"></i></button>
    </div>

    {{ Form::close() }}
</div>

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

<script>
    $(function(){

        // Select with search
        $('.select-search').select2();

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