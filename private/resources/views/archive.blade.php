@extends('layouts.app')
@section('content')
<div id="container" class="opacity" style="position: relative; background: none; border: none;">
	<h2>{{ $title }}</h2>
	<div class="hr2"></div>
	@include('layouts.info')
	<div class="full-width">
		<div id="showDataOnhold">
			<table>
				<thead>
					<th width="20%">Time</th>
					<th>Attacker</th>
					<th>Team</th>
					<th class="th-archive">H</th>
					<th class="th-archive">M</th>
					<th class="th-archive">R</th>
					<th class="th-archive">L</th>
					<th class="special" class="th-archive">&#9733;</th>
					<th>Domain</th>
					{{--<th>Server</th>--}}
					<th>View</th>
				</thead>
				<tbody>
					@foreach ($archives as $row)
					@php
						$parse = parse_url($row->url);
						$location = json_decode($row->geolocation);
					@endphp
					<tr>
						<td>{{ $row->datetime }}</td>
						<td>
							{{ $row->notifier }}
						</td>
						<td>
							{{ $row->team }}
						</td>
						<td class="th-archive">{{ ($row->home  == '1') ? 'H' : '' }}</td>
						<td class="th-archive">{{ ($row->mass  == '1') ? 'M' : '' }}</td>
						<td class="th-archive">{{ ($row->redeface == '1') ? 'R' : '' }}</td>
						<td class="th-archive">
							@if($location->code == 'Unknown')
								?
							@else
								<img src="{{ url('images/flags/'.strtolower($location->code).'.png') }}" title="{{ $location->country }}">
							@endif
						</td>
						<td class="special" class="th-archive">{{ ($row->special == '1') ? '&#9733;' : '' }}</td>
						<td>{{ (strlen($parse['host'].$parse['path']) <= 20) ? $parse['host'].$parse['path'] : substr($parse['host'].$parse['path'], 0, 20).'...'  }}</td>
						{{--<td>{{ $technology->server }}</td>--}}
						<td>
							<a href="{{ url('view/mirror/'.$row->id) }}" target="_blank">Mirror</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
	</div>
	<div class="hr1"></div>
	<br>
	<br>
	<div class="page-navi" id="paging_button">
		{{ $archives->links() }}
	</div>
	<div class="transify" style="background-color: rgba(38, 38, 38, 0.901961); background-image: none; background-repeat: repeat; border-color: rgb(181, 181, 181); border-width: 0px; border-style: none; position: absolute; top: 0px; left: 0px; z-index: -1; width: 960px; height: 100%; opacity: 0.8;">
	</div>
</div>
@stop