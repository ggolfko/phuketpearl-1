<?php
    $name = App\Config::where('property', 'name')->first()->value;
    $copy = App\Config::where('property', 'copyright')->first()->value;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title>{{$name}} - 404</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/favicon.ico" rel="icon" type="image/x-icon">
<link href="/favicon.png" rel="icon" type="image/png">
<link href="/favicon.gif" rel="icon" type="image/gif">
<link href="/favicon.ico" rel="shortcut icon">
<link href="/static/frontend/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/plugins/animate.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/css/ui.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/css/error.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="/static/crossbrowserjs/html5shiv.js"></script>
<script src="/static/crossbrowserjs/respond.min.js"></script>
<script src="/static/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container ui-error">
        <div class="row main">
            <div class="col-md-8">
                <div class="padding hidden-xs"></div>
                <div class="status-code">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 404
                </div>
                <div class="status-message">
                    Page Not Found
                </div>
                <div class="detail">
                    This page does not exist or has been deleted, please check again, or you can go to our other pages.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="foot">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="copyright">
                                {!! $copy !!}
                            </div>
                        </div>
                        <div class="col-md-7 visible-xs visible-sm">
                            <div class="menu left">
                                <a href="/?home">{{trans('_.Home')}}</a>
                                <a href="/jewels">{{trans('_.Pearl Jewels')}}</a>
                                <a href="/gallery.html">{{trans('_.Gallery')}}</a>
                                <a href="/news">{{trans('_.News')}}</a>
                                <a href="/tours">{{trans('_.Booking Tour')}}</a>
                                <a href="/contactus.html">{{trans('_.Contact us')}}</a>
                            </div>
                        </div>
                        <div class="col-md-7 visible-md visible-lg">
                            <div class="menu right">
                                <a href="/?home">{{trans('_.Home')}}</a>
                                <a href="/jewels">{{trans('_.Pearl Jewels')}}</a>
                                <a href="/gallery">{{trans('_.Gallery')}}</a>
                                <a href="/news">{{trans('_.News')}}</a>
                                <a href="/tours">{{trans('_.Booking Tour')}}</a>
                                <a href="/contactus.html">{{trans('_.Contact us')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
