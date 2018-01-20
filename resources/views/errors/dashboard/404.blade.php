<?php
    $name = App\Config::where('property', 'name')->first()->value;
?>
<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{$name}}</title>
<link href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="/static/dashboard/assets/css/bootstrap-reset.css" rel="stylesheet">
<link href="/static/dashboard/assets/css/style.css" rel="stylesheet">
<link href="/static/dashboard/assets/css/style-responsive.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="/static/dashboard/assets/js/html5shiv.js"></script>
<script src="/static/dashboard/assets/js/respond.min.js"></script>
<![endif]-->
</head><body class="body-404">
    <div class="container">
        <section class="error-wrapper">
            <i class="icon-404"></i>
            <h1>404</h1>
            <h2>page not found</h2>
            <p class="page-404">Something went wrong or that page doesn’t exist yet. <a href="/dashboard">Return Home</a></p>
        </section>
    </div>
</body></html>
