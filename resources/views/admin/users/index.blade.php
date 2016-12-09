@extends('admin.layouts.master')
@section('title', 'Smart Panel')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/datatables_buttons.css" rel="stylesheet" type="text/css">
    @endsection

    @section('page-header')

            <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Üyeler</span> /
                    Üye Listesi</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-link btn-float has-text"><i
                                class="icon-plus3 text-primary"></i><span>Yeni Kullanıcı Ekle</span></a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="datatable_responsive.html">Üyeler</a></li>
                <li class="active">Üye Listesi</li>
            </ul>

            <ul class="breadcrumb-elements">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-gear position-left"></i>
                        Filtrele
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ route('admin.users.show', ['sort' => 'list']) }}"><i class="icon-sort-numeric-asc"></i> Sıralamaya Göre</a></li>
                        <li><a href="{{ route('admin.users.show', ['sort' => 'desc']) }}"><i class="icon-sort"></i> ID'ye göre</a></li>
                        <li><a href="{{ route('admin.users.show', ['sort' => 'active']) }}"><i class="icon-checkmark-circle"></i> Aktifler</a></li>
                        <li><a href="{{ route('admin.users.show', ['sort' => 'passive']) }}"><i class="icon-blocked"></i> Pasifler</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.users.show', ['sort' => 'all']) }}"><i class="icon-list-unordered"></i> Tümü</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    @if(Session::has('sort') && Session::get('sort') == 'list')
    <div class="alert bg-primary alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Sürükle bırak seçeneği ile sıralamayı değiştirebilirsiniz.</span>
    </div>
    @endif

    <!-- Basic responsive configuration -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Üye Listesi</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            The <code>Responsive</code> extension for DataTables can be applied to a DataTable in one of two ways; with
            a specific <code>class name</code> on the table, or using the DataTables initialisation options. This method
            shows the latter, with the <code>responsive</code> option being set to the boolean value <code>true</code>.
            The <code>responsive</code> option can be given as a boolean value, or as an object with configuration
            options.
        </div>
        {{ Form::open(['id' => 'datatable-form']) }}
        <table class="table datatable-responsive table-striped">
            <thead>
            <tr>
                <th><input value="1" type="checkbox" id="select-all"></th>
                <th>Id</th>
                <th>Aktif</th>
                <th>Adı Soyadı</th>
                <th>Email</th>
                <th>Güncelleme Tar.</th>
                <th>İşlem</th>
            </tr>
            </thead>

            <tbody>
            </tbody>

        </table>

        <div class="row form-action form-group">
            <div class="col-md-12">
                <div class="pull-left margin-right-10 action-selectbox">
                    <select class="select" name="action">
                        <optgroup label="Toplu işlemler ">
                            <option value="">İşlem türü seçiniz ?</option>
                            <option value="active">Seçili öğeleri aktif et</option>
                            <option value="passive">Seçili öğeleri pasif et</option>
                            <option value="destroy">Seçili öğeleri sil</option>
                        </optgroup>
                    </select>
                </div>
                <div class="pull-left">
                    <button class="btn bg-slate-600"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <!-- form action -->
        {{ Form::close() }}
    </div>
    <!-- /basic responsive configuration -->

    @endsection

    @section('js')
    <!-- Theme JS files -->
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/pages/datatables_responsive.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/cms/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script type="text/javascript" src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/cms/js/dataTables_drawdt.js"></script>
    <!-- /theme JS files -->

    <script>
        $(function () {
            $('.datatable-responsive').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.users.data') !!}',
                retrieve: true,
                paging: true,
                pageLength: '{{(Session::get('sort') == 'list') ? '100' : 25 }}',
                columns: [
                    {data: 'checkbox', name: 'id', orderable: false, searchable: false},
                    {data: 'id', name: 'id', orderable: true, searchable: true},
                    {data: 'active', name: 'active'},
                    {data: 'first_name', name: 'first_name', exportable: true},
                    {data: 'email', name: 'email', orderable: true, searchable: true},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, exportable: true}
                ],
                dom: 'Bfrtip',
                buttons: ["export", "print"],
            });
        });

        $(".datatable-responsive").on("click", ".confirm-btn", function (e) {

            var id = $(this).data("id");
            var url = $(this).data("url");
            var token = $(this).data("token");
            var title = $(this).data("title");

            bootbox.confirm("(<strong>" + title + "</strong>) isimli kullanıcı siliniyor. Onaylıyor musunuz ?", function (result) {
                if (result == true) {
                    $.ajax({
                        url: url,
                        data: {_token: token},
                        type: 'DELETE',
                        success: function (result) {
                            window.location.href = result
                        }
                    });
                }
            });
        });

        // Datatable Form
        $(function () {
            var oTable;
            $('#datatable-form').submit(function () {
                var item_id = oTable.$('input').serialize();
                var status = $('select[name=action]').val();
                $.ajax({
                    url: '{{ route('admin.users.multiple') }}',
                    data: {item_id: item_id, status: status},
                    type: 'POST',
                    success: function (data) {
                        var result = $.parseJSON(JSON.stringify(data));
                        swal({
                            title: result.message,
                            confirmButtonColor: "#66BB6A",
                            type: result.status,
                        }, function () {
                            location.reload();
                        });
                    }
                });
                return false;
            });
            oTable = $('.datatable-responsive').dataTable();
        });

        @if(Session::has('sort') && Session::get('sort') == 'list')
            $(function () {
            $("tbody").sortable({
                opacity: 0.8, cursor: 'move', update: function () {
                    var order = $(this).sortable("serialize");
                    $.get("{{ route('admin.users.show', ['sort' => 'sort']) }}", order, function (response) {
                        var result = $.parseJSON(JSON.stringify(response));
                        swal({
                            title: result.message,
                            confirmButtonColor: "#66BB6A",
                            type: result.status,
                        }, function () {
                            location.reload();
                        });
                    });
                }
            });
        });
        @endif

    </script>

@endsection












