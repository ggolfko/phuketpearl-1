@extends('dashboard.layout')

@section('head')
<style>
.ui-table tbody tr td:first-child{
	width:190px;
	padding-left:18px;
}
.ui-table tbody tr td ul{
	padding-left: 17px;
}
.ui-table tbody tr td ul li{
	list-style: circle;
    margin-top: 2px;
    margin-bottom: 2px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-4">
								<a href="/dashboard/products" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
		                    </div>
                            <div class="col-md-8">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/jewels/{{$product->url}}.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
									<!-- <a href="/dashboard/products/{{$product->productid}}/hooks" class="btn btn-danger btn-sm">
										{{trans('product.Hooks')}}
									</a> -->
									<a href="/dashboard/products/{{$product->productid}}/quality" class="btn btn-danger btn-sm">
										{{trans('product.Quality')}}
									</a>
                                    <a href="/dashboard/products/{{$product->productid}}/images" class="btn btn-danger btn-sm">
										{{trans('product.Product Images')}}
									</a>
                                    <a href="/dashboard/products/{{$product->productid}}/edit" class="btn btn-danger btn-sm">
										{{trans('_.Edit')}}
									</a>
								</form>
                            </div>
						</div>
                    </header>
                    <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
                            <tr>
		                        <td><strong>{{trans('_.Publish')}}</strong></td>
		                        <td>
                                    @if($product->publish == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($product->publish == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Views')}}</strong></td>
		                        <td>{{number_format($product->views)}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Title')}}</strong></td>
		                        <td>{!! $product->getTitle($config['lang']['code']) !!}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('product.Code')}}</strong></td>
		                        <td>{{$product->code}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.URL')}}</strong></td>
		                        <td>{{config('app.url')}}/<strong>{{$product->url}}</strong>.html</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('jewel.Pearl Type')}}</strong></td>
		                        <td>
                                    <?php $peraltype = $product->getPearltype($config['lang']['code']); ?>
                                    @if(trim($peraltype) == '')
                                    -
                                    @else
                                    {!! nl2br($peraltype) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('jewel.Colour')}}</strong></td>
		                        <td>
                                    <?php $bodytype = $product->getBodytype($config['lang']['code']); ?>
                                    @if(trim($bodytype) == '')
                                    -
                                    @else
                                    {!! nl2br($bodytype) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('jewel.Size')}}</strong></td>
		                        <td>
                                    <?php $size = $product->getPearlsize($config['lang']['code']); ?>
                                    @if(trim($size) == '')
                                    -
                                    @else
                                    {!! nl2br($size) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('jewel.Material')}}</strong></td>
		                        <td>
                                    <?php $materials = $product->getMaterials($config['lang']['code']); ?>
                                    @if(trim($materials) == '')
                                    -
                                    @else
                                    {!! nl2br($materials) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('jewel.Description')}}</strong></td>
		                        <td>
                                    <?php $description = $product->getMoredetails($config['lang']['code']); ?>
                                    @if(trim($description) == '')
                                    -
                                    @else
                                    {!! nl2br($description) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('product.Category')}}</strong></td>
		                        <td>
                                    @if($product->categories->count() < 1)
                                        -
                                    @else
                                        <ul>
                                            @foreach($product->categories as $map)
                                                @if($map->category)
                                                <li>{{$map->category->getTitle($config['lang']['code'])}}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Keywords')}}</strong></td>
		                        <td>{!! $keywords !!}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Created at')}}</strong></td>
		                        <td>{{$product->created_at->format('d F Y H:i:s')}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Updated at')}}</strong></td>
		                        <td>{{$product->updated_at->format('d F Y H:i:s')}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Options')}}</strong></td>
		                        <td>
                                    <button type="button" class="btn btn-sm btn-danger" ng-disabled="deleting || deleted" ng-click="delete()">[[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]</button>
                                </td>
		                    </tr>
		                </tbody>
		            </table>
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
app.controller('Item', function($scope, $window, $http){
    $scope.deleting = false;
    $scope.deleted  = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/products/{{$product->productid}}/delete')
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $window.location.href = '/dashboard/products';
                }
                else{
                    alert(resp.message);
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            })
            .finally(function(){
                $scope.deleting = false;
            });
        }
    };
});

$(function(){
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
});
</script>
@endsection
