@extends('layouts.app')
@section('content')
@php
	$location   = json_decode($archive->geolocation);
	$technology = json_decode($archive->technology);
@endphp
<div id="container" class="opacity" style="position: relative; background: transparent none repeat scroll 0% 0%; border: medium none;">
	<div id="FrameArchive">
		<h4 style="color:#b5b5b5;font-size:14px">Mirror of <strong>{{ $archive->url }}</strong></h4>
		<div class="hr2" style="margin-top:-10px;margin-bottom:5px;"></div>
		<div class="one-third">
			<p>Mirror saved on: <strong>{{ $archive->datetime }}</strong></p>
			<p>IP: <strong>{{ $archive->ip }}</strong> <img src="{{ url('images/flags/'.$location->code.'.png') }}" title="{{ $location->country }}" style="display: inline;margin-bottom:1px;">
			</p>
		</div>
		<div class="one-third">
			<p>Notifier: <strong>{{ $archive->notifier }}</strong></p>
			<p>System: <strong>{{ $technology->os }}</strong></p>
		</div>
		<div class="one-third last">
			<p>Team: <strong>{{ $archive->team }}</strong></p>
			<p>Web Server: <strong>{{ $technology->server }}</strong></p>
		</div>
		<div class="full-width">
			<p style="margin-top:50px;">This is a CACHE (mirror) page of the site when it was saved by our robot on <strong>{{ $archive->datetime }}</strong> </p>
		</div>
		<div class="clear"></div>
		<div class="full-width">
			<div class="hr2" style="margin-top:5px;margin-bottom:10px;"></div>
				<iframe class="mirror_frame" src="{{ url('view/source/'.$id) }}"></iframe>
			<div class="clear"></div>
		</div>
	</div>
	<div class="transify" style="background-color: rgba(38, 38, 38, 0.901961); background-image: none; background-repeat: repeat; border-color: rgb(181, 181, 181); border-width: 0px; border-style: none; position: absolute; top: 0px; left: 0px; z-index: -1; width: 960px; height: 100%; opacity: 0.8;">
	</div>
</div>
@stop