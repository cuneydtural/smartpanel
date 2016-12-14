@extends('admin.layouts.choose')
@section('title', 'Smart Panel')

@section('css')
    <link href="/cms/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/datatables_buttons.css" rel="stylesheet" type="text/css">
    @endsection

    @section('content')
    <!-- Basic responsive configuration -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Fotoğraf Kütüphanesi</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <table class="table datatable-responsive table-striped">
            <thead>
            <tr>
                <th><input value="1" type="checkbox" id="select-all"></th>
                <th>Önizleme</th>
                <th>Dosya Adı</th>
                <th>Dosya Bilgileri</th>
                <th>Oluşturulma Tar.</th>
                <th width="50">İşlem</th>
            </tr>
            </thead>

            <tbody>
            </tbody>

        </table>

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
                ajax: '{!! route('admin.photo-library.choose.data') !!}',
                retrieve: true,
                paging: true,
                pageLength: '5',
                columns: [
                    {data: 'checkbox', name: 'id', orderable: false, searchable: false},
                    {data: 'preview', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'info', name: 'mime', orderable: true, searchable: true},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                dom: 'Bfrtp',
                buttons: [],
            });
        });

        // Datatable Form
        $(function () {
            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });
        });

    </script>

@endsection
