<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{$config['lang']['code']}}" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{$config['lang']['code']}}" ng-app="app">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<title>Howto - Map</title>
<link href="/static/frontend/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/plugins/animate.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/css/ui.css" rel="stylesheet" type="text/css">
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
    padding: 20px 18px;
	width: 1000px;
	margin: 0 auto;
}
.doc-content .block {
	margin-bottom: 20px;
	border-bottom: 1px solid #ccc;
	padding: 25px 0px;
}
.doc-content p {
    font-size: 15px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 20px;
    color: #000;
	margin-bottom: 20px;
}
.doc-content a {
    color: #000;
    text-decoration: underline;
    font-size: 13px;
}
.doc-content img {
    max-width: 100%;
	border: 1px solid #ccc;
	border-radius: 4px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}
.doc-content iframe {
    max-width: 100%;
}
</style>
<!--[if lt IE 9]>
<script src="/static/crossbrowserjs/html5shiv.js"></script>
<script src="/static/crossbrowserjs/respond.min.js"></script>
<script src="/static/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
</head>
<body style="background-color:#fff !important;">

    <div class="doc-content">
		<div class="block">
			<p>
				{{trans('howto.MAP_01')}}
			</p>
			<img src="/static/dashboard/assets/img/howto/map/01.png">
		</div>

		<div class="block">
			<p>
				{{trans('howto.MAP_02')}}
			</p>
			<img src="/static/dashboard/assets/img/howto/map/02.png">
		</div>

		<div class="block">
			<p>
				{{trans('howto.MAP_03')}}
			</p>
			<img src="/static/dashboard/assets/img/howto/map/03.png">
		</div>

		<div class="block">
			<p>
				{{trans('howto.MAP_04')}}
			</p>
			<img src="/static/dashboard/assets/img/howto/map/04.png">
		</div>
    </div>

</body>
</html>
