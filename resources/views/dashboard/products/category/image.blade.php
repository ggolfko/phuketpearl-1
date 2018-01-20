@extends('dashboard.layout')

@section('head')
<style>
.display-image {
	display: block;
}
.display-image img {
	display: block;
	max-width: 100%;
	border: 1px solid #ccc;
}
ul.note {
	margin-top: 15px;
	padding-left: 17px;
}
ul.note li {
	list-style: circle;
	margin-bottom: 3px;
}
.ui-process {
	position: absolute;
	right: 15px;
	top: 8px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row" ng-controller="content">
            <div class="col-lg-10">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/products/category" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('category.Category Image')}}</span>
								<button type="button" class="btn btn-danger btn-sm pull-right" ng-click="chooseFile()" ng-show="!doing && !done">
									{{trans('_.Upload')}}
								</button>
								@if($category->imageid != '' && strlen($category->imageid) == 16)
								<button type="button" class="btn btn-danger btn-sm pull-right" ng-click="remove()" ng-show="!doing && !done" style="margin-right: 5px;">
									{{trans('_.Remove')}}
								</button>
								@endif
								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile">
								<img src="/static/dashboard/assets/img/process.gif" class="ui-process pull-right" ng-class="{'hidden': !doing || done}">
							</div>
						</div>
                    </header>
                    <div class="panel-body">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
						<div class="row">
							<div class="col-lg-6">
								<div class="display-image">
									@if($category->imageid != '' && strlen($category->imageid) == 16)
										<img src="/app/category/{{$category->categoryid}}/{{$category->imageid}}.png">
									@else
										<img src="/static/dashboard/images/category-placeholder.png">
									@endif
								</div>
							</div>
							<div class="col-lg-6">
								<span class="label label-danger">{{trans('_.Note')}}</span> <br>
								<ul class="note">
									<li>{{trans('category.Recommended image size 450px x 450px')}}</li>
									<li>{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}</li>
								</ul>
							</div>
						</div>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
@if(session()->has('sMessage'))
noty({
	text: '{!!session('sMessage')!!}',
	layout: 'topRight',
	type: 'success',
	dismissQueue: true,
	template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
	animation: {
		open: {height: 'toggle'},
		close: {height: 'toggle'},
		easing: 'swing',
		speed: 300
	},
	timeout: 4500
});
@endif

app.controller('content', function($scope, $timeout, $window, $http){
	$scope.remove = function(){
		if (confirm('{{trans('_.Are you sure?')}}'))
		{
			$scope.doing = true;

			$http.post('/ajax/dashboard/products/category/{{$category->categoryid}}/removeimage', {
				id: {{$category->id}}
			})
			.success(function(resp){
				if (resp.status == 'ok'){
					$scope.done  = true;
					$window.location.reload();
				}
				else {
					alert(resp.message);
				}
			})
			.error(function(){
				alert('{{trans('error.general')}}');
				$window.location.reload();
			})
			.finally(function(){
				$scope.doing = false;
			});
		}
	}

	$scope.chooseFile = function(){
		$('#uploadFile').trigger('click');
	}

	$(function(){
		$('#uploadFile').bind('change', function(e){
            if ($(this).val() != '' && e.target.files.length == 1)
            {
				var file = e.target.files[0];

				if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) >= 0)
				{
					$scope.doing = true;
					$scope.$apply();

					var formData = new FormData();
					formData.append('file', file);
					formData.append('id', '{{$category->id}}');
					formData.append('_token', '{{csrf_token()}}');

					$.ajax({
						url: '/ajax/dashboard/products/category/{{$category->categoryid}}/image',
						type: 'POST',
						processData: false,
						contentType: false,
						dataType: 'JSON',
						data: formData
					})
					.success(function(resp){
						if (resp.status == 'ok')
						{
							$scope.doing = false;
							$scope.done  = true;
							$scope.$apply();
							$window.location.reload();
						}
						else {
							alert(resp.message);
							$scope.doing = false;
							$scope.$apply();
						}
					})
					.error(function(){
						alert('{{trans('error.general')}}');
						$scope.doing = false;
						$scope.$apply();
						$window.location.reload();
					});
				}
				else {
					alert('{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}');
				}
            }
        });
	});
});
</script>
@endsection
