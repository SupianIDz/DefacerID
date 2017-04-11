@extends('layouts.app')
@section('content')
<div id="container" class="opacity">
	<h2>Top 10 Attackers</h2>
	<div class="hr2"></div>
	<div class="full-width">
		<div id="Top10Attacker">
			<table>
				<tbody>
					<tr style="background:rgba(0,0,0,0.5);">
						<th style="width:20px;">Rank</th>
						<th width="40%">Attacker</th>
						<th>Special</th>
						<th>Onhold</th>
						<th>Published</th>
						<th>Total</th>
					</tr>
					@php
						$rank = 1;
					@endphp
					@foreach($notifiers as $row)
					<tr>
						<td>{{ $rank }}</td>
						<td>{{ $row->notifier }}</td>
						<td>{{ $row->special }}</td>
						<td>{{ ($row->total - $row->published) }}</td>
						<td>{{ $row->published }}</td>
						<td>{{ $row->total }}</td>
					</tr>
					@php
					$rank++;
					@endphp
					@endforeach
					
				</tbody>
			</table>
		</div>
		<div class="clear">
		</div>
	</div>
	<h2>Top 10 Teams
	</h2>
	<div class="hr2">
	</div>
	<div class="full-width">
		<div id="Top10Team">
			<table>
				<tbody>
					<tr style="background:rgba(0,0,0,0.5);">
						<th style="width:20px;">Rank</th>
						<th width="40%">Team</th>
						<th>Special</th>
						<th>Onhold</th>
						<th>Published</th>
						<th>Total</th>
					</tr>
					@php
					$rank = 1;
					@endphp
					@foreach($teams as $row)
					<tr>
						<td>{{ $rank }}</td>
						<td>{{ $row->team }}</td>
						<td>{{ $row->special }}</td>
						<td>{{ ($row->total - $row->published) }}</td>
						<td>{{ $row->published }}</td>
						<td>{{ $row->total }}</td>
					</tr>
					@php
						$rank++;
					@endphp
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="clear">
		</div>
	</div>
	<h2>Recent Special Archive
	</h2>
	<div class="hr2">
	</div>
	<div class="full-width">
		<div id="RecentSpecial">
			<table>
				<tbody>
					<tr style="background:rgba(0,0,0,0.5);">
						<th width="17%">Time</th>
						<th width="22%">Attacker</th>
						<th width="20%">Team</th>
						<th class="th-archive">H</th>
						<th class="th-archive">M</th>
						<th class="th-archive">R</th>
						<th class="th-archive">L</th>
						<th class="th-archive special">&#9733;</th>
						<th>Domain</th>
						<th width="">View</th>
					</tr>
					@foreach($specials as $row)
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
						<td class="th-archive special">{{ ($row->special == '1') ? '&#9733;' : '' }}</td>
						<td>{{ (strlen($parse['host'].$parse['path']) <= 25) ? $parse['host'].$parse['path'] : substr($parse['host'].$parse['path'], 0, 25).'...'  }}</td>
						<td>
							<a href="{{ url('view/mirror/'.$row->id) }}" target="_blank">Mirror</a>
						</td>
					</tr>
					
					@endforeach
					
				</tbody>
			</table>
		</div>
		<div class="clear">
		</div>
	</div>
	<h2>Recent Archive
	</h2>
	<div class="hr2">
	</div>
	<div class="full-width">
		<div id="RecentArchive">
			<table>
				<tbody>
					<tr style="background:rgba(0,0,0,0.5);">
						<th width="17%">Time</th>
						<th width="22%">Attacker</th>
						<th width="20%">Team</th>
						<th class="th-archive">H</th>
						<th class="th-archive">M</th>
						<th class="th-archive">R</th>
						<th class="th-archive">L</th>
						<th class="th-archive special">&#9733;</th>
						<th>Domain</th>
						<th width="">View</th>
					</tr>
					@foreach($archives as $row)
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
						<td class="th-archive special">{{ ($row->specialattack == '1') ? '&#9733;' : '' }}</td>
						<td>{{ (strlen($parse['host'].$parse['path']) <= 25) ? $parse['host'].$parse['path'] : substr($parse['host'].$parse['path'], 0, 25).'...'  }}</td>
						<td>
							<a href="{{ url('view/mirror/'.$row->id) }}" target="_blank">Mirror</a>
						</td>
					</tr>
					
					@endforeach
					
				</tbody>
			</table>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
@stop