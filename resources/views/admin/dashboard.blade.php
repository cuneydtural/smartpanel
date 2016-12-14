@extends('admin.layouts.master')
@section('title', 'Smart Panel')
@section('css')
<style>
    .c3-axis-x text {
        font-size:11px;
    }

</style>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- Quick stats boxes -->
        <div class="row">
            <div class="col-lg-3">

                <!-- Members online -->
                <div class="panel bg-slate">
                    <div class="panel-body">
                        <h3 class="no-margin">{{$visitors}}</h3>
                        Kullanıcılar
                        <div class="text-muted text-size-small">Google Analytics /  ({{ session('day', '30') }} Gün) </div>
                    </div>

                    <div class="container-fluid">
                        <div id="members-online"></div>
                    </div>
                </div>
                <!-- /members online -->

            </div>

            <div class="col-lg-3">
                <!-- Members online -->
                <div class="panel bg-pink">
                    <div class="panel-body">
                        <h3 class="no-margin">{{$pageviews}}</h3>
                        Sayfa Görüntülemeleri
                        <div class="text-muted text-size-small">Google Analytics /  ({{ session('day', '30') }} Gün) </div>
                    </div>

                    <div class="container-fluid">
                        <div id="members-online"></div>
                    </div>
                </div>
                <!-- /members online -->
            </div>

            <div class="col-lg-2">
                <!-- Current server load -->
                <div class="panel bg-blue">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ \App\Helpers\System::getSystemLoad() }} %</h3>
                        CPU Kullanımı
                        <div class="text-muted text-size-small">Sunucu Yönetimi</div>
                    </div>
                </div>
                <!-- /current server load -->
            </div>

            <div class="col-lg-2">
                <!-- Current server load -->
                <div class="panel bg-indigo">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ \App\Helpers\System::getServerMemory() }}</h3>
                        Bellek Kullanımı
                        <div class="text-muted text-size-small">Sunucu Yönetimi</div>
                    </div>
                </div>
                <!-- /current server load -->
            </div>

            <div class="col-lg-2">
                <!-- Current server load -->
                <div class="panel bg-orange-700 ">
                    <div class="panel-body">
                        <h3 class="no-margin">{{ $diskUsedSpace }} %</h3>
                        Disk: <b>{{ $diskFreeSpace }}</b>
                        <div class="text-muted text-size-small">Sunucu Yönetimi</div>
                    </div>
                </div>
                <!-- /current server load -->
            </div>

        </div>
        <!-- /quick stats boxes -->
    </div>

    <div class="col-md-12">
        <!-- Categorized axes -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"><span class="text-highlight bg-primary">Oturumlar</span></h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-popup="tooltip" title="Menu"><i class="icon-three-bars"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('admin.dashboard.show', ['day' => '7']) }}">7 Gün</a></li>
                                <li><a href="{{ route('admin.dashboard.show', ['day' => '15']) }}">15 Gün</a></li>
                                <li><a href="{{ route('admin.dashboard.show', ['day' => '30']) }}">30 Gün</a></li>
                                <li><a href="{{ route('admin.dashboard.show', ['day' => '60']) }}">60 Gün</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-container">
                    <div class="chart" id="c3-axis-categorized"></div>
                </div>
            </div>
        </div>
        <!-- /xategorized axes -->
    </div>
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title text-semibold"><span class="text-highlight bg-primary">Popüler Tarayıcı</span></h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="chart-container text-center">
                    <div class="display-inline-block" id="c3-donut-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title text-semibold"><span class="text-highlight bg-primary">Ziyaretçi Kaynağı</span></h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="chart-container text-center">
                    <div class="display-inline-block" id="c3-donut-chart-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title text-semibold"><span class="text-highlight bg-primary">Ziyaretçi Trafiği</span></h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="chart-container text-center">
                    <div class="display-inline-block" id="user-types"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Table -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"><span class="text-highlight bg-primary">Sayfalara Göre Oturumlar</span></h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive table-striped">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sayfa Başlığı</th>
                        <th>Görüntülenme</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 1; ?>
                    @foreach($mostVisitedPages as $mostVisitedPage)
                        @if ($count == 11)
                            @continue
                        @endif
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{$mostVisitedPage['pageTitle']}}</td>
                        <td><span class="badge bg-primary">{{$mostVisitedPage['pageViews']}}</span></td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /table -->
    </div>
    <div class="col-md-6">
        <!-- Table -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"><span class="text-highlight bg-primary">Şehire Göre Oturumlar</span></h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive table-striped">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Şehir</th>
                        <th>Görüntülenme</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 1; ?>
                    @foreach($analyticsCity as $city)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{$city[0]}}</td>
                            <td><span class="badge bg-primary">{{$city[1]}}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /table -->
    </div>


    </div>


@endsection

@section('js')
<!-- Theme JS files -->

    <script type="text/javascript" src="/cms/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/visualization/c3/c3.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>

    <script>
        var donut_chart = c3.generate({
            bindto: '#c3-donut-chart',
            size: { width: 300 },
            color: {
                pattern: ['#3F51B5', '#FF9800', '#4CAF50', '#00BCD4', '#F44336']
            },
            data: {
                columns: [
                        @foreach($browsers as $browser)
                    ['{{$browser['browser']}}', {{$browser['sessions']}}],
                        @endforeach
                ],
                type : 'donut'
            },
            donut: {
                title: "Popüler Tarayıcı"
            }
        });

        var donut_chart2 = c3.generate({
            bindto: '#c3-donut-chart-2',
            size: { width: 300 },
            color: {
                pattern: ['#3F51B5', '#FF9800', '#4CAF50', '#00BCD4', '#F44336']
            },
            data: {
                columns: [
                        @foreach($referrers as $referrer)
                    ['{{$referrer['url']}}', {{$referrer['pageViews']}}],
                    @endforeach
                ],
                type : 'donut'
            },
            donut: {
                title: "Ziyaretçi Kaynağı"
            }
        });

        var donut_chart3 = c3.generate({
            bindto: '#user-types',
            size: { width: 300 },
            color: {
                pattern: ['#3F51B5', '#FF9800', '#4CAF50', '#00BCD4', '#F44336']
            },
            data: {
                columns: [
                        @foreach($userTypes as $userType)
                    ['{{$userType[0]}}', {{$userType[1]}}],
                    @endforeach
                ],
                type : 'donut'
            },
            donut: {
                title: "Gelen Bağlantılar"
            }
        });

        var axis_categorized = c3.generate({
            bindto: '#c3-axis-categorized',
            size: { height: 400 },
            data: {
                columns: [
                    ['Oturumlar', <?php echo $analyticsPageViews ?>]
                ]
            },
            color: {
                pattern: ['#eb7312']
            },
            axis: {
                x: {
                    type: 'category',
                    tick: {
                        culling: {
                            max: 5
                        },
                        rotate: 0,
                        multiline: false
                    },
                    height: 40,
                    categories: [<?php echo $analyticsDates ?>],
                }
            },
            grid: {
                x: {
                    show: true
                }
            }
        });

    </script>
@endsection
