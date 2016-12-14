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
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fotoğraf Kütüphanesi</span> /
                    Fotoğraflar</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="javascript:;" class="btn btn-link btn-float has-text" data-toggle="modal" data-target="#file-upload-modal">
                        <i class="icon-upload text-primary"></i><span>Yeni Fotoğraf Yükle</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
                <li><a href="datatable_responsive.html">Fotoğraf Kütüphanesi</a></li>
                <li class="active">Fotoğraflar</li>
            </ul>

            <ul class="breadcrumb-elements">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-gear position-left"></i>
                        Filtrele
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ route('admin.photo-library.show', ['sort' => 'list']) }}"><i class="icon-sort-numeric-asc"></i> Sıralamaya Göre</a></li>
                        <li><a href="{{ route('admin.photo-library.show', ['sort' => 'desc']) }}"><i class="icon-sort"></i> ID'ye göre</a></li>
                        <li><a href="{{ route('admin.photo-library.show', ['sort' => 'active']) }}"><i class="icon-checkmark-circle"></i> Aktifler</a></li>
                        <li><a href="{{ route('admin.photo-library.show', ['sort' => 'passive']) }}"><i class="icon-blocked"></i> Pasifler</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.photo-library.show', ['sort' => 'all']) }}"><i class="icon-list-unordered"></i> Tümü</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @endsection

    @section('content')

    <!-- Primary modal -->
    <div id="file-upload-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Fotoğraf Yükle</h6>
                </div>

                <div class="modal-body">
                  {{ Form::open(['route' => 'admin.photo-library.store', 'class' => 'dropzone col-md-12', 'id'=>'dropzone_multiple']) }}
                  {{ Form::close() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-all">Yükle</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /primary modal -->

    @if(Session::has('sort') && Session::get('sort') == 'list')
    <div class="alert bg-primary alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Sürükle bırak seçeneği ile sıralamayı değiştirebilirsiniz.</span>
    </div>
    @endif

    <!-- Basic responsive configuration -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Fotoğraflar</h5>
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
                <th>Önizleme</th>
                <th>Aktif</th>
                <th>Dosya Adı</th>
                <th>Dosya Bilgileri</th>
                <th>Oluşturulma Tar.</th>
                <th width="50">İşlem</th>
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
    <script type="text/javascript" src="/cms/js/plugins/media/fancybox.min.js"></script>
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
    <script type="text/javascript" src="/cms/js/plugins/uploaders/dropzone.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/cms/js/dataTables_drawdt.js"></script>
    <!-- /theme JS files -->

    <script>
        $(function () {
            $('.datatable-responsive').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.photo-library.data') !!}',
                retrieve: true,
                paging: true,
                pageLength: '{{(Session::get('sort') == 'list') ? '100' : 25 }}',
                columns: [
                    {data: 'checkbox', name: 'id', orderable: false, searchable: false},
                    {data: 'preview', name: 'name'},
                    {data: 'active', name: 'active'},
                    {data: 'name', name: 'name'},
                    {data: 'info', name: 'mime', orderable: true, searchable: true},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [],
            });
        });

        $(".datatable-responsive").on("click", ".confirm-btn", function (e) {

            var id = $(this).data("id");
            var url = $(this).data("url");
            var token = $(this).data("token");
            var title = $(this).data("title");

            bootbox.confirm("(<strong>" + title + "</strong>) isimli fotoğraf siliniyor. Onaylıyor musunuz ?", function (result) {
                if (result == true) {
                    $.ajax({
                        url: url,
                        data: {_token: token},
                        type: 'DELETE',
                        success: function (result) {
                            var result = $.parseJSON(JSON.stringify(result));
                            swal({
                                title: result.message,
                                confirmButtonColor: "#66BB6A",
                                type: result.status,
                            }, function () {
                                $('.datatable-responsive').DataTable().ajax.reload();
                                //location.reload();
                            });
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
                    url: '{{ route('admin.photo-library.multiple') }}',
                    data: {item_id: item_id, status: status},
                    type: 'POST',
                    success: function (data) {
                        var result = $.parseJSON(JSON.stringify(data));
                        swal({
                            title: result.message,
                            confirmButtonColor: "#66BB6A",
                            type: result.status,
                        }, function () {
                            $('.datatable-responsive').DataTable().ajax.reload();
                            //location.reload();
                        });
                    }
                });
                return false;
            });

            oTable = $('.datatable-responsive').dataTable();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });
        });

        @if(Session::has('sort') && Session::get('sort') == 'list')
            $(function () {
            $("tbody").sortable({
                opacity: 0.8, cursor: 'move', update: function () {
                    var order = $(this).sortable("serialize");
                    $.get("{{ route('admin.photo-library.show', ['sort' => 'sort']) }}", order, function (response) {
                        var result = $.parseJSON(JSON.stringify(response));
                        swal({
                            title: result.message,
                            confirmButtonColor: "#66BB6A",
                            type: result.status,
                        }, function () {
                            $('.datatable-responsive').DataTable().ajax.reload();
                            //location.reload();
                        });
                    });
                }
            });
        });
        @endif

        // Multiple files
        $("#dropzone_multiple").dropzone({
            paramName: "image", // The name that will be used to transfer the file
            dictDefaultMessage: 'Sürükle bırak yada <span>çift tıkla!</span>',
            dictRemoveFile: 'Fotoğrafı sil',
            addRemoveLinks: true,
            autoProcessQueue : false,
            parallelUploads: 50,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
            init: function() {

                var submit_button = document.querySelector("#submit-all")
                var my_dropzone = this;

                submit_button.addEventListener("click", function() {
                    my_dropzone.processQueue();
                });

                this.on("success", function(image, response) {
                    var result = $.parseJSON(JSON.stringify(response));
                    new PNotify({
                        text: result.message,
                        type: result.status,
                        addclass: 'alert alert-'+ result.status +' alert-styled-right',
                    });
                });
                this.on("queuecomplete", function(file) {

                    $('#file-upload-modal').modal('hide');
                    $('.datatable-responsive').DataTable().ajax.reload();

                    swal({
                        title: 'Tüm dosyalar yüklendi',
                        confirmButtonColor: "#66BB6A",
                        type: 'success'
                    }, function () {
                        my_dropzone.removeAllFiles();
                    });
                });
            }
        });

    </script>

@endsection
