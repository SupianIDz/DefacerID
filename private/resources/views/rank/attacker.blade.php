@extends('layouts.app')
@section('content')
<div id="container" class="opacity" style="position: relative; background: none; border: none;">
  <h2>Attacker Ranking</h2>
  <div class="hr2"></div>
  <span class="count-defacer" style="text-align:center;display:block;margin-bottom:5px">Total
    <strong>{{ $countofattacker }}</strong> Attacker from <strong>{{ $countofteam }}</strong> Team.
  </span>
  <div class="full-width">
    <div id="showDataRankAttacker">
      <table>
        <thead>
          <tr style="background:rgba(0,0,0,0.5);">
            <th style="width:20px;">Rank</th>
            <th width="45%">Attacker</th>
            {{--<th>Team</th>--}}
            <th>Home</th>
            <th>Special</th>
            <th>Published</th>
            <th>Total</th>
          </tr>
        </thead>
        </body>
        @php
          $rank = 1;
        @endphp
        @foreach($attackers as $row)
          <tr>
            <td>{{ $rank }}</td>
            <td>{{ $row->notifier }}</td>
            {{--<td>{{ $row->team }}</td>--}}
            <td>{{ $row->home }}</td>
            <td>{{ $row->special }}</td>
            <td>{{ $row->published }}</td>
            <td>{{ $row->total }}</td>
          </tr>
        @php
          $rank++;
        @endphp
        @endforeach
        </table>
      </table>
    </div>
    <div class="clear">
    </div>
  </div>
  <div class="hr1">

  </div>
  <br>
  <br>
  <div class="page-navi" id="paging_button">
  {{ $attackers->links() }}
  </div>
  <div class="transify" style="background-color: rgba(38, 38, 38, 0.901961); background-image: none; background-repeat: repeat; border-color: rgb(181, 181, 181); border-width: 0px; border-style: none; position: absolute; top: 0px; left: 0px; z-index: -1; width: 960px; height: 100%; opacity: 0.8;">
  </div>
</div>
@stop