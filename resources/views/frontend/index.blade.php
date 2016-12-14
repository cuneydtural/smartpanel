<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laravel Smart Panel</title>
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/sticky-footer/sticky-footer.css" rel="stylesheet">
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h2>Laravel Smart-Panel v6</h2>
    </div>
    <p>Admin paneli için lütfen aşağaki linke tıklayın.</p>
    <p><a class="btn btn-primary" href="{{ Request::url().'/admin' }}"> {{ Request::url().'/admin' }}</a></p>

    <div class="bs-callout bs-callout-info" id="callout-navbar-breakpoint">
        <p><br>Kullanıcı bilgileri <code>database/seeds/UserTableSeeders.php</code> dosyasında belirtilmiştir.</p>
    </div>
</div>

</body>
</html>
