
@if($awards->count() > 0 || $cers->count() > 0)
<div class="home-popular-awards">
	<div class="container">
		<div class="group_home_collections row">
			<div class="col-xs-12 text-center">
				<div class="__head __light">
					<div class="__title {{$config['lang']['code']}}">{{trans('_.Awards & Certificates')}}</div>
					<img src="/static/images/home_line.png">
				</div>
			</div>
			<div class="col-md-12">
				<div class="home_awards hidden">
					<div id="home_awards">
						@foreach($awards as $award)
						<?php $title_ = $award->getTitle($config['lang']['code']) ?>
						<div class="home_awards_item">
							<div class="home_awards_item_inner">
								<div class="award-details">
									<img src="/app/award/{{$award->awardid}}/{{$award->imageid}}_t.png" alt="{{$title_}}">
								</div>
							</div>
							<div class="hover-overlay">
								<span class="col-name">
									<a href="" rel="me" alt="{{$title_}}">{{$title_}}</a>
								</span>
							</div>
						</div>
						@endforeach @foreach($cers as $cer)
						<?php $title_ = $cer->getTitle($config['lang']['code']) ?>
						<div class="home_awards_item">
							<div class="home_awards_item_inner">
								<div class="award-details">
									<img src="/app/certificate/{{$cer->certificateid}}/{{$cer->imageid}}_t.png" alt="{{$title_}}">
								</div>
							</div>
							<div class="hover-overlay">
								<span class="col-name">
									<a href="" rel="me" alt="{{$title_}}">{{$title_}}</a>
								</span>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif