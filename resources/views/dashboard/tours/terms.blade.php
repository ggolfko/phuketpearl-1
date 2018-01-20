@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_editor.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/quick_insert.css">
<link rel="stylesheet" href="/static/bower_components/codemirror/lib/codemirror.css">
<style>
.ui-editor {
    position: relative;
}
.ui-editor .bottom {
    position: absolute;
    width: 170px;
    height: 25px;
    background-color: #fff;
    z-index: 10000;
    margin-top: -25px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Terms">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<a href="/dashboard/tours" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('_.Terms and Conditions')}}</span>
							</div>
                            <div class="col-md-6">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
									<button type="button" class="btn btn-danger btn-sm" ng-disabled="saving" ng-click="save()">
										{{trans('_.Save')}}
									</button>
								</form>
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
                        <form class="form-horizontal tasi-form" method="post" action="" name="form" enctype="multipart/form-data" id="form">
                            <div class="form-group" data-group="content">
                                <div class="col-sm-12">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#content-{{$locale['code']}}" aria-controls="content-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="content-{{$locale['code']}}">
                                                <div class="ui-editor">
                                                    <textarea data-plugin="froala-editor" name="content[{{$locale['code']}}]">{!! $doc->getContent($locale['code']) !!}</textarea>
                                                    <div class="bottom"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
							</div>

                            <button type="submit" class="hidden"></button>
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
<script type="text/javascript" src="/static/bower_components/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="/static/bower_components/codemirror/mode/xml/xml.js"></script>

<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/froala_editor.min.js" ></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/languages/{{$config['lang']['code']}}.js"></script>

<script>
app.controller('Terms', function($scope){
    $scope.saving = false;

    $scope.save = function(){
        $scope.saving = true;
        $('#form').submit();
    };
});

$(function(){
    $('[data-plugin=froala-editor]').froalaEditor({
        heightMin: $(document).height()-340,
        placeholderText: '{{trans('tour.Terms and conditions of tour booking')}}',
        language: '{{$config['lang']['code']}}',
		toolbarSticky: false
    });
});
</script>
@endsection
