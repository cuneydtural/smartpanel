@if(count($locales))
<!-- Table -->
<div class="panel panel-flat">
    <div class="table-responsive table-striped">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Kategori Adı</th>
                <th>Dil</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locales as $locale)
                <tr>
                    <td>{{ $locale->id }}</td>
                    <td>{{$locale->name}}</td>
                    <td><span class="label label-info">{{$locale->locale}}</span></td>
                    <td>
                        <button data-id="{{ $locale->id }}" data-category-id="{{ $locale->category_id }}" class="edit-locale btn btn-xs border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-cog7"></i></button>
                        <a href="{{ route('admin.categories.locale.delete', ['id' => $locale->id]) }}" class="remove-locale btn btn-xs border-warning text-warning-600 btn-flat btn-icon btn-rounded"><i class="icon-cross"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /table -->
@else
<div class="alert alert-warning alert-bordered">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
    <span class="text-semibold">Üzgünüz!</span> Henüz bu kategoriye dil eklemediniz! Dil eklemek için <a class="alert-link" data-toggle="modal" data-target="#create-locale">tıklayınız</a>
</div>
@endif

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
<script type="text/javascript" src="/cms/js/pages/form_validation.js"></script>
<!-- /theme JS files -->
