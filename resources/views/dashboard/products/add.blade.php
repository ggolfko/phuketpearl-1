@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" type="text/css" href="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<style>
.bootstrap-tagsinput {
    width: 100%;
    padding-top: 2px;
    padding-bottom: 6px;
}
.tag.label.label-danger {
    padding-top: 2.5px !important;
    padding-bottom: 2.5px !important;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/products" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('product.Add New Product')}}</span>
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
                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="form" id="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('product.Category')}}</label>
                                <div class="col-sm-9">
									<div class="checkboxes">
                                        @foreach($categories as $category)
                                        <label class="label_check c_on">
											<input name="category[]" value="{{$category->categoryid}}" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{$category->getTitle($config['lang']['code'])}}</span>
										</label>
                                        @endforeach
									</div>
								</div>
                            </div>

                            <div class="form-group hidden">
                                <label class="col-sm-3 control-label">{{trans('product.About product')}}</label>
                                <div class="col-sm-9">
									<div class="checkboxes">
                                        <label class="label_check c_on">
											<input name="about_new" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('product.New product')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="about_popular" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('product.Popular product')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="about_recommend" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('product.Recommended product')}}</span>
										</label>
									</div>
								</div>
                            </div>

                            <div class="form-group" data-group="title">
                                <label class="col-sm-3 control-label">{{trans('_.Title')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#title-{{$locale['code']}}" aria-controls="title-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="title-{{$locale['code']}}">
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" autocomplete="off" data-input-title="{{$locale['code']}}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="code">
                                <label class="col-sm-3 control-label">{{trans('jewel.Code')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="code" maxlength="50" autocomplete="off">
								</div>
                            </div>

							<div class="form-group" data-group="url">
                                <label class="col-sm-3 control-label">{{trans('_.URL')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="url" maxlength="128" autocomplete="off">
									<p class="help-block">
                                        <em>{{trans('category.Allowed characters A-Z a-z 0-9 and - only.')}}</em>
                                    </p>
                                    <p class="help-block">
                                        <em>{{trans('_.Example')}} : {{config('app.url')}}/<strong>product-alias</strong>.html</em>
                                    </p>
								</div>
                            </div>

                            <div class="form-group" data-group="pearltype">
                                <label class="col-sm-3 control-label">{{trans('jewel.Pearl Type')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#pearltype-{{$locale['code']}}" aria-controls="pearltype-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="pearltype-{{$locale['code']}}">
                                                <textarea placeholder="({{trans('_.optional')}})" class="form-control" name="pearltype[{{$locale['code']}}]" data-input-pearltype="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;"></textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="bodytype">
                                <label class="col-sm-3 control-label">{{trans('jewel.Colour')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#bodytype-{{$locale['code']}}" aria-controls="bodytype-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="bodytype-{{$locale['code']}}">
                                                <textarea placeholder="({{trans('_.optional')}})" class="form-control" name="bodytype[{{$locale['code']}}]" placeholder="" data-input-bodytype="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;"></textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="pearlsize">
                                <label class="col-sm-3 control-label">{{trans('jewel.Size')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#pearlsize-{{$locale['code']}}" aria-controls="pearlsize-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="pearlsize-{{$locale['code']}}">
                                                <textarea placeholder="({{trans('_.optional')}})" class="form-control" name="pearlsize[{{$locale['code']}}]" data-input-pearlsize="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;"></textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="materials">
                                <label class="col-sm-3 control-label">{{trans('jewel.Material')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#materials-{{$locale['code']}}" aria-controls="materials-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="materials-{{$locale['code']}}">
                                                <textarea placeholder="({{trans('_.optional')}})" class="form-control" name="materials[{{$locale['code']}}]" placeholder="" data-input-materials="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;"></textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="moredetails">
                                <label class="col-sm-3 control-label">{{trans('jewel.Description')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#moredetails-{{$locale['code']}}" aria-controls="moredetails-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="moredetails-{{$locale['code']}}">
                                                <textarea placeholder="({{trans('_.optional')}})" class="form-control" name="moredetails[{{$locale['code']}}]" data-input-moredetails="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;"></textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Keywords')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keywords" class="form-control" placeholder="({{trans('_.optional')}})" autocomplete="off" id="ipt-keywords">
								</div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Publish')}}</label>
                                <div class="col-sm-9">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="publish" value="yes" data-plugin="icheck" checked> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="publish" value="no" data-plugin="icheck"> {{trans('_.No')}}
									</label>
								</div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">{{trans('_.Add')}}</button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </div>
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
<script src="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script>
$(function(){
    autosize($('[data-plugin=autosize]'));

    $("#ipt-keywords").tagsinput({
        tagClass: 'label label-danger',
        trimValue: true
    });

    $('#form').bind('submit', function(e){
        $(this).find('[data-group]').removeClass('has-error');

        var title       = true,
            url         = true,
            iptUrl      = $(this).find('input[name=url]'),
            code        = true,
            iptCode     = $(this).find('input[name=code]');

        $(this).find('input[data-input-title]').each(function(index, item){
            if ($(item).val().trim() == ''){
                title = false;
            }
        });
        if (title == false){
            $(this).find('[data-group=title]').addClass('has-error');
        }

        if (iptUrl.val().trim() == '' || !/^[a-zA-Z0-9-]+$/.test(iptUrl.val())){
            $(this).find('[data-group=url]').addClass('has-error');
            url = false;
        }

        if (iptCode.val().trim() == ''){
            $(this).find('[data-group=code]').addClass('has-error');
            code = false;
        }

        if (title && url && code){
            $(this).find('button[type=submit]').attr('disabled', true);
            return true;
        }

        e.preventDefault();
    });
});
</script>
@endsection
