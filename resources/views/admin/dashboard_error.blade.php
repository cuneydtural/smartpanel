@extends('admin.layouts.master')
@section('title', 'Smart Panel')
@section('css')
@endsection

@section('page-header')

<div class="col-md-12">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Dashboard</span> /Index</h4>
            </div>
        </div>
        <div class="breadcrumb-line breadcrumb-line-component bg-grey">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-home2 position-left"></i> Dashboard</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- /page header -->
@endsection

@section('content')
<div class="col-md-12">
    <div class="alert alert-info alert-styled-left alert-bordered">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">{{ $info['tr'] }}
    </div>
</div>

<div class="col-md-6">
    <!-- Basic responsive table -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"><span class="text-highlight bg-primary">İletişim Formu</span></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Adı Soyadı</th>
                    <th>Eklenme Tarihi</th>
                    <th>Durum</th>
                    <th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach($contact_forms as $contact_form)
                <tr>
                    <td>{{ $contact_form->name }}</td>
                    <td>{{ $contact_form->updated_at }}</td>
                    <td>
                        @if($contact_form->active == 1)
                            <span class="label label-success">Cevaplandı</span>
                        @endif

                        @if($contact_form->active == 0)
                            <span class="label label-warning">Cevap Bekliyor.</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{ route('admin.forms.edit', array('id' => $contact_form->id)) }}"><i class="icon-list"></i> Form Detayı</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /basic responsive table -->
</div>
<div class="col-md-6">
    <!-- Basic responsive table -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"><span class="text-highlight bg-primary">Biz Sizi Arayalım</span></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Adı Soyadı</th>
                    <th>Eklenme Tarihi</th>
                    <th>Durum</th>
                    <th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach($callback_forms as $callback_form)
                    <tr>
                        <td>{{ $callback_form->name }}</td>
                        <td>{{ $callback_form->updated_at }}</td>
                        <td>
                            @if($callback_form->active == 1)
                                <span class="label label-success">Cevaplandı</span>
                            @endif

                            @if($callback_form->active == 0)
                                <span class="label label-warning">Cevap Bekliyor.</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('admin.forms.edit', array('id' => $callback_form->id)) }}"><i class="icon-list"></i> Form Detayı</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /basic responsive table -->
</div>
@endsection


@section('js')
<!-- Theme JS files -->
<script type="text/javascript" src="/cms/js/plugins/visualization/d3/d3.min.js"></script>
<script type="text/javascript" src="/cms/js/plugins/visualization/c3/c3.min.js"></script>
<script type="text/javascript" src="/cms/js/core/app.js"></script>
@endsection
