@extends('dashboard.layout')

@section('head')
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Form">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								{{trans('story.Our Story')}} <i class="fa fa-angle-right" aria-hidden="true" style="margin:0px 5px;"></i> {{trans('story.Article')}}
							</div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/our-story.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" ng-click="save()" ng-disabled="saving">
                                        {{trans('_.Save changes')}}
                                    </button>
                                </form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 150px)">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
                        @if(session()->has('sMessage'))
                        <div class="alert alert-success fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('sMessage')}}
						</div>
                        @endif
                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="form" id="form">
                            <div class="form-group" data-group="detail">
                                <div class="col-xs-12">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#detail-{{$locale['code']}}" aria-controls="detail-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="detail-{{$locale['code']}}">
                                                <textarea class="form-control" rows="10" style="resize:none;" data-plugin="autosize" name="detail[{{$locale['code']}}]" data-input-detail="{{$locale['code']}}">{!! $story->getDetail($locale['code']) !!}</textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
(function(){
    app.controller('Form', function($scope){
        $scope.save = function(){
            $scope.saving = true;
            $('#form').submit();
        };
        $(function(){
            autosize($('[data-plugin=autosize]'));

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                autosize.update($('[data-plugin=autosize]'));
            });
        });
    });
})();
</script>
@endsection
