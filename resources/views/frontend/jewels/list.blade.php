@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/frontend/css/jewels.css?_t=1705170035" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-jewels" ng-class="{'xs':screen == 'xs'}">
    <div class="container list">
        <div class="row">
            <div class="col-xs-12">
                <div class="head" ng-class="{'xs':screen == 'xs'}">
                    <div class="line"></div>
                    <div class="category">
                        <span>{{$category->getTitle($config['lang']['code'])}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($items as $index => $map)
            {{-- */ $product = App\Product::find($map->product_id); /* --}}
                @if($product)
                {{-- */ $productTitle = $product->getTitle($config['lang']['code']) /* --}}
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a href="/jewels/{{$product->url}}.html" class="item" alt="{{$productTitle}}">
                        <div class="image">
                            {{-- */ $source = '/static/images/product-not-image.jpg'; /* --}}
                            @if($product->images->count() > 0)
                                {{-- */ $image = $product->images()->where('cover', '1')->first(); /* --}}
                                @if($image)
                                    {{-- */ $source = "/app/product/{$product->productid}/{$image->imageid}_t.png"; /* --}}
                                @endif
                            @endif
                            <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$productTitle}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-600-600.jpg" class="holder" alt="{{$productTitle}}">
                                </div>
                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                            </div>
                        </div>
                        <div class="info" ng-class="{'fixheight': screen == 'lg' || screen == 'md' || screen == 'sm'}">
                            {{$productTitle}}
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12">
                {!! $items->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')
<script>
(function(){
    app.controller('DeferImage', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
            alt: $attrs.alt
        });
        $scope.image.bind('load', function(){
            $('.image-showing', $element).html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });
    });
})();
</script>
@endsection
