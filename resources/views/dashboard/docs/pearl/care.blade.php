@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_editor.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/image.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/video.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/file.css">
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
.fr-wrapper {
    padding-bottom: 10px !important;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Form">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								{{trans('_.Pearl Care')}}
                                <button type="button" class="btn btn-danger btn-sm pull-right" ng-click="save()" ng-disabled="saving" style="margin-left:5px;">
                                    {{trans('_.Save changes')}}
                                </button>
                                <a href="/pearl-care.html" target="_blank" class="btn btn-default btn-sm pull-right">
                                    {{trans('_.View on Frontend')}}
                                </a>
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
                        @if(session()->has('sMessage'))
                        <div class="alert alert-success fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('sMessage')}}
						</div>
                        @endif
                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="form" enctype="multipart/form-data" id="form">
                            <div class="form-group">
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
                                                    <textarea data-plugin="froala-editor" name="content[{{$locale['code']}}]">{!! $item->getContent($locale['code']) !!}</textarea>
                                                    <div class="bottom"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
							</div>

                            <button type="submit" class="hidden"></button>
                            <input type="hidden" name="imageid" value="">
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
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/image.min.js"></script>
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
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/languages/{{$config['lang']['code']}}.js"></script>

<script>
(function(){
    app.controller('Form', function($scope){
        $scope.saving = false;

        $scope.save = function(){
            $scope.saving = true;
            $('#form').submit();
        };
    });
})();


$(function(){
    $('[data-plugin=froala-editor]').froalaEditor({
        heightMin: 300,
        placeholderText: '{{trans('_.Content')}}...',
        language: '{{$config['lang']['code']}}',
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
        imageUploadParams: {
            _token: '{{csrf_token()}}'
        },
        imageUploadURL: '/ajax/dashboard/docs/pearlcare/image',
        toolbarSticky: false
    });
});
</script>
@endsection
