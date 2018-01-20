@extends('dashboard.layout')

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
								<a href="/dashboard/products/category" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('category.Edit Category Information')}}</span>
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
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" maxlength="128" autocomplete="off" data-input-title="{{$locale['code']}}" value="{{$category->getTitle($locale['code'])}}">
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>
							<div class="form-group" data-group="url">
                                <label class="col-sm-3 control-label">{{trans('_.URL')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="url" maxlength="128" autocomplete="off" value="{{$category->url}}">
									<p class="help-block">
                                        <em>{{trans('category.Allowed characters A-Z a-z 0-9 and - only.')}}</em>
                                    </p>
                                    <p class="help-block">
                                        <em>{{trans('_.Example')}} : {{config('app.url')}}/jewels/<strong>new-category</strong></em>
                                    </p>
								</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">{{trans('_.Save changes')}}</button>
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
<script>
$(function(){
    $('#form').bind('submit', function(e){
        $(this).find('[data-group]').removeClass('has-error');

        var title   = true,
            url     = true,
            iptUrl  = $(this).find('input[name=url]');

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

        if (title && url){
            $(this).find('button[type=submit]').attr('disabled', true);
            return true;
        }

        e.preventDefault();
    });
});
</script>
@endsection
