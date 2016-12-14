<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Panel</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/cms/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/core.min.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/components.css" rel="stylesheet" type="text/css">
    <link href="/cms/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="/cms/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="/cms/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="/cms/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/cms/js/plugins/notifications/pnotify.min.js"></script>
    <script type="text/javascript" src="/cms/js/pages/components_notifications_pnotify.js"></script>
    <script type="text/javascript" src="/cms/js/core/app.js"></script>
    <script type="text/javascript" src="/cms/js/pages/login.js"></script>
    <!-- /theme JS files -->

</head>

<body class="login-container">

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html"><img src="/cms/images/logo_light.png" alt=""></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="#">
                    <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
                </a>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-cog3"></i>
                    <span class="visible-xs-inline-block position-right"> Options</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Advanced login -->
                <form action="{{ route('admin.login') }}" method="post">

                    {!! csrf_field() !!}

                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Hesabınıza giriş yapın<small class="display-block">Kullanıcı Bilgileriniz</small></h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" name="email" class="form-control" placeholder="E-Mail adresiniz" value="{{ old('email') }}">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" name="password" class="form-control" placeholder="Şifreniz">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="styled" checked="checked">
                                        Şifremi Hatırla
                                    </label>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <a href="{{ url('password/reset') }}">Şifremi Unuttum</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Giriş Yap <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </form>
                <!-- /advanced login -->

                <!-- Footer -->
                <div class="footer text-muted text-center">
                    &copy; 2015. <a href="#">Master CMS</a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>


<script>
    @if($errors->count())
    $(function(){
        @foreach($errors->all() as $error)
                new PNotify({
            title: '',
            text: '{{$error}}',
            icon: 'icon-warning22'
        });
        @endforeach
    });
    @endif

    @if(Session::has('message'))
    $(function(){
        new PNotify({
            title: '',
            text: '{{ Session::get('message') }}',
            icon: 'icon-warning22'
        });
    });
    @endif
</script>
