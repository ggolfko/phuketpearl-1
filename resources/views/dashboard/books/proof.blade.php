@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
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

.bank {
    position: relative;
    float: left;
    width: 100%;
}
.bank .image {
    position: relative;
    float: left;
    width: 40px;
    padding: 5px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.bank .image img {
    width: 100%;
}
.bank .detail {
    position: relative;
    float: left;
    width: calc(100% - 40px);
    padding-left: 10px;
}
.bank .detail span {
    display: block;
    width: 100%;
}
.bank .detail small {
    display: block;
    width: 100%;
    font-size: 12px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">
        @foreach($book->informs as $index => $inform)
		     @if($index == 0)
             <div class="row">
                 <div class="col-lg-10">
     		        <section class="panel">
     		            <header class="panel-heading">
     		                <div class="row">
     		                    <div class="col-sm-12">
     								<a href="/dashboard/booking/{{$book->bookid}}" class="btn btn-danger btn-sm">
     									<i class="fa fa-chevron-left"></i>
     		                            {{trans('_.Back')}}
     		                        </a>
                                    @if($book->informs->count() > 1)
                                    <span style="font-size: 14px; margin-left: 10px;">{{trans('book.Sent time')}}: {{$inform->created_at->format('d F Y H:i:s')}}</span>
                                    @endif
     		                    </div>
     		                </div>
     		            </header>
     		            <table class="table table-striped table-advance ui-table">
     		                <thead></thead>
     		                <tbody>
                                 <tr>
     		                        <td style="vertical-align: top !important;"><strong>{{trans('book.Our bank account')}}</strong></td>
                                     <td>
                                         @if($inform->map && $inform->map->bank)
                                         <div class="bank">
                                             <div class="image" style="background-color:{{$inform->map->bank->color}};">
                                                 <img src="/static/plugins/banks-logo/th/{{$inform->map->bank->acronym}}.svg">
                                             </div>
                                             <div class="detail">
                                                 <span>{{$inform->map->bank->thai_name}}</span>
                                                 <small>{{$inform->map->bank->official_name}}</small>
                                                 <small>{{$inform->map->account}}</small>
                                                 <small>{{$inform->map->number}}</small>
                                                 <small>{{$inform->map->type}}</small>
                                                 <small>{{$inform->map->branch}}</small>
                                             </div>
                                         </div>
                                         @endif
                                     </td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('book.Transfer time')}}</strong></td>
                                     <td>{{dateTime($inform->time, 'd F Y H:i:s')}}</td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('book.Amount transferred')}}</strong></td>
                                     <td>{{number_format($inform->amount)}} THB</td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('_.Note')}}</strong></td>
                                     <td>
                                         @if(trim($inform->note) == '')
                                             -
                                         @else
                                             {!! nl2br($inform->note) !!}
                                         @endif
                                     </td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('_.Image')}}</strong></td>
                                     <td>
                                         <a href="/app/inform/{{$inform->informid}}.png" class="fancybox"><img src="/app/inform/{{$inform->informid}}.png" class="img-responsive"></a>
                                     </td>
     		                    </tr>
     		                </tbody>
     		            </table>
     		        </section>
     			</div>
     		</div>
            @else
            <div class="row">
                <div class="col-lg-10">
                    <hr style="border-color: #d1d1d1;">
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-10">
     		        <section class="panel">
     		            <header class="panel-heading">
     		                <div class="row">
     		                    <div class="col-sm-12">
     								<span style="font-size: 14px;">{{trans('book.Sent time')}}: {{$inform->created_at->format('d F Y H:i:s')}}</span>
     		                    </div>
     		                </div>
     		            </header>
     		            <table class="table table-striped table-advance ui-table">
     		                <thead></thead>
     		                <tbody>
                                 <tr>
     		                        <td style="vertical-align: top !important;"><strong>{{trans('book.Our bank account')}}</strong></td>
                                     <td>
                                         @if($inform->map && $inform->map->bank)
                                         <div class="bank">
                                             <div class="image" style="background-color:{{$inform->map->bank->color}};">
                                                 <img src="/static/plugins/banks-logo/th/{{$inform->map->bank->acronym}}.svg">
                                             </div>
                                             <div class="detail">
                                                 <span>{{$inform->map->bank->thai_name}}</span>
                                                 <small>{{$inform->map->bank->official_name}}</small>
                                                 <small>{{$inform->map->account}}</small>
                                                 <small>{{$inform->map->number}}</small>
                                                 <small>{{$inform->map->type}}</small>
                                                 <small>{{$inform->map->branch}}</small>
                                             </div>
                                         </div>
                                         @endif
                                     </td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('book.Transfer time')}}</strong></td>
                                     <td>{{dateTime($inform->time, 'd F Y H:i:s')}}</td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('book.Amount transferred')}}</strong></td>
                                     <td>{{number_format($inform->amount)}} THB</td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('_.Note')}}</strong></td>
                                     <td>
                                         @if(trim($inform->note) == '')
                                             -
                                         @else
                                             {!! nl2br($inform->note) !!}
                                         @endif
                                     </td>
     		                    </tr>
                                 <tr>
     		                        <td><strong>{{trans('_.Image')}}</strong></td>
                                     <td>
                                         <a href="/app/inform/{{$inform->informid}}.png" class="fancybox"><img src="/app/inform/{{$inform->informid}}.png" class="img-responsive"></a>
                                     </td>
     		                    </tr>
     		                </tbody>
     		            </table>
     		        </section>
     			</div>
     		</div>
            @endif
        @endforeach
    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script>
$(function(){
    $(".fancybox").fancybox({
        closeBtn: false,
        padding: 8
    });
});
</script>
@endsection
