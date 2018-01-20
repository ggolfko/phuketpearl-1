@extends('dashboard.layout')

@section('head')
<style>
.ui-table tbody tr td:first-child{
	width:150px;
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
<section id="main-content" class="hidden">
    <section class="wrapper">
		<div class="row">
            <div class="col-lg-8">

		        <section class="panel">
		            <header class="panel-heading">
		                <div class="row">
		                    <div class="col-sm-12">
								<a href="/dashboard/employees" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{$person->firstname}} {{$person->lastname}}</span>
								<a href="/dashboard/employees/{{$person->userid}}/edit" class="btn btn-danger btn-sm pull-right">
									<i class="fa fa-pencil-square ui-fa top2"></i>
		                            {{trans('_.Edit')}}
		                        </a>
		                    </div>
		                </div>
		            </header>
					@if(session()->has('sMessage'))
					<div class="panel-body">
						<div class="alert alert-success fade in" style="margin-bottom: 0px;">
							{{session('sMessage')}}
						</div>
					</div>
					@endif
		            <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
		                    <tr>
		                        <td><strong>{{trans('employee.Employee ID')}}</strong></td>
		                        <td>{{$person->userid}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Status')}}</strong></td>
		                        <td>
									@if($person->status == 'a')
									<span class="label label-default">{{trans('_.'.$person->getStatus())}}</span>
									@elseif($person->status == 'p')
									<span class="label label-warning"><em>{{trans('_.'.$person->getStatus())}}</em></span>
									@elseif($person->status == 'b')
									<span class="label label-danger"><em>{{trans('_.'.$person->getStatus())}}</em></span>
									@endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Username')}}</strong></td>
		                        <td>{{$person->username}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Email address')}}</strong></td>
		                        <td><a href="mailto:{{$person->email}}">{{$person->email}}</a></td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Language')}}</strong></td>
		                        <td>{{$person->getLanguage()}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Permissions')}}</strong></td>
		                        <td>
                                    @if(
                                        $person->permission_product == '0' &&
                                        $person->permission_tour == '0' &&
                                        $person->permission_newsletter == '0' &&
                                        $person->permission_news == '0' &&
                                        $person->permission_contact == '0' &&
                                        $person->permission_document == '0' &&
                                        $person->permission_setting == '0' &&
                                        $person->permission_employee == '0' &&
                                        $person->permission_gallery == '0' &&
                                        $person->permission_video == '0' &&
                                        $person->permission_book == '0' &&
                                        $person->permission_payment == '0' &&
                                        $person->permission_enquiry == '0'
                                    )
                                        -
                                    @else
                                        <ul>
                                        @if($person->permission_product == '1')
                                			<li>{{trans('employee.Product management')}}</li>
                                		@endif
                                        @if($person->permission_enquiry == '1')
                                			<li>{{trans('_.Jewel enquiry')}}</li>
                                		@endif
                                        @if($person->permission_tour == '1')
                                			<li>{{trans('_.Package tours')}}</li>
                                		@endif
                                        @if($person->permission_book == '1')
                                			<li>{{trans('_.Tour Booking')}}</li>
                                		@endif
                                        @if($person->permission_newsletter == '1')
                                			<li>{{trans('_.Newsletter')}}</li>
                                		@endif
                                        @if($person->permission_news == '1')
                                			<li>{{trans('_.News')}}</li>
                                		@endif
                                        @if($person->permission_contact == '1')
                                			<li>{{trans('_.Contacts')}}</li>
                                		@endif
                                        @if($person->permission_document == '1')
                                			<li>{{trans('_.Documents')}}</li>
                                		@endif
                                        @if($person->permission_payment == '1')
                                			<li>{{trans('payment.Payments')}}</li>
                                		@endif
                                        @if($person->permission_setting == '1')
                                			<li>{{trans('employee.The settings of the site')}}</li>
                                		@endif
                                        @if($person->permission_employee == '1')
                                			<li>{{trans('employee.Employee management')}}</li>
                                		@endif
                                        @if($person->permission_gallery == '1')
                                			<li>{{trans('_.Gallery')}}</li>
                                		@endif
                                        @if($person->permission_video == '1')
                                			<li>{{trans('_.Videos')}}</li>
                                		@endif
                                        </ul>
                                    @endif
                                </td>
		                    </tr>
							@if($person->rpassword != '')
							<tr>
		                        <td><strong>{{trans('employee.Default password')}}</strong></td>
		                        <td>
									{{Crypt::decrypt($person->rpassword)}} &nbsp;
									<em>({{trans('employee.This employee has never changed the password.')}})</em>
								</td>
		                    </tr>
							@endif
							<tr>
		                        <td><strong>{{trans('_.Created at')}}</strong></td>
		                        <td>{{$person->created_at->format('d F Y H:i:s')}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Updated at')}}</strong></td>
		                        <td>{{$person->updated_at->format('d F Y H:i:s')}}</td>
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
