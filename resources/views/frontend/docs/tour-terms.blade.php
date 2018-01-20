<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{$config['lang']['code']}}" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{$config['lang']['code']}}" ng-app="app">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="{{ $config['url'] }}/static/frontend/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/plugins/animate.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/ui.css" rel="stylesheet" type="text/css">
<style>
.doc-content {
    position: relative;
    display: block;
    font-size: 13px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 20px;
    margin-top: 10px;
    margin-bottom: 15px;
    color: #000;
    padding: 0px 18px;
}
.doc-content p {
    font-size: 13px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 20px;
    color: #000;
}
.doc-content a {
    color: #000;
    text-decoration: underline;
    font-size: 13px;
}
.doc-content img {
    max-width: 100%;
}
.doc-content iframe {
    max-width: 100%;
}
</style>
<!--[if lt IE 9]>
<script src="{{ $config['url'] }}/static/crossbrowserjs/html5shiv.min.js"></script>
<script src="{{ $config['url'] }}/static/crossbrowserjs/respond.min.js"></script>
<script src="{{ $config['url'] }}/static/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
</head>
<body style="background-color:#fff !important;">

    <div class="doc-content">
        {!! nl2br($doc->getContent($config['lang']['code'])) !!}
    </div>

</body>
</html>
