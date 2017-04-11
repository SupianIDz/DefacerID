@extends('layouts.app')
@section('content')
<div id="container" class="opacity">
	<h2>Notify Attacks</h2>
	<div class="hr2"></div>
	<div class="info-defacer">
		<span class="info-defacer-title">Rules & Conditions</span>
		<span>
			<ol style="margin:0;font-size:13px;">
				<li>
					Add one url in each line in Urls textarea.
				</li>
				<li>Only sub-domains are allowed from
					<strong>Government ( .gov ) </strong>and<strong> Academic ( .ac ) </strong>sites.
				</li>
				<li>
					Site Suspended Hacks ( e.g. <strong>http://example.com/cgi-sys/suspendedpage.cgi</strong> ) add here without suspended page url (<strong>/cgi-sys/suspendedpage.cgi</strong> ). Mean add only the domain name (<strong>http://example.com</strong> ).
				</li>
				<li>
					Any Kind of Picture Deface will not accepted for example <strong>http://example.com/example.png</strong> or <strong>http://example.com/uploads/eample.jpg</strong>
				</li>
				<li>
					Deface page will not accepted with ~ <strong>http://example.com/~abcd/index.xxx</strong> or <strong>http://example.com/uploads/eample.jpg</strong>
				</li>
			</ol>
		</span>
	</div>
	<div class="full-width">
		<div class="form-container center" style="margin-top:20px;">
			<div class="forms" action="" method="post" id="frmNotify">
				<fieldset>
					<ol>
						<li class="form-row text-input-row">
							<label>Attacker :</label>
							<input class="text-input" id="attacker" placeholder="Attacker">
						</li>
						<li class="form-row text-input-row">
							<label>Team :</label>
							<input class="text-input" id="team" placeholder="Team">
						</li>
						<li class="form-row text-input-row">
							<label>Type :</label>
							<select class="select" id="poc">
								@foreach ($concepts as $concept)
								<option value="{{ $concept->id }}">{{ $concept->title }}</option>
								@endforeach
							</select>
						</li>
						<li class="form-row text-area-row">
							<label>URLs :</label>
							<textarea class="text-area required" id="url" rows="10"></textarea>
						</li>
						<li class="button-row" style="float:right;">
							<button class="btn-submit" id="submit">Submit</button>
						</li>
					</ol>
				</fieldset>
			</div>
		</div>
		<br>
		<div class="clear"></div>
		<div class="info-defacer" id="result">
			<span class="info-defacer-title">Result</span>
			<span>
				<div id="resultNotify"></div>
				<br />
				<div style="clear:both">
				</div>
			</span>
		</div>
		<br>
	</div>
	<div class="hr1">
	</div>
</div>
@stop
@section('js')
	<script type="text/javascript" src="{{ url('js/jquery.js') }}"></script>
	<script type="text/javascript">
		var ajaxCall;
		Array.prototype.remove = function(value) {
		    var index = this.indexOf(value);
		    if (index != -1) {
		        this.splice(index, 1);
		    }
		    return this;
		};

		function UpdateTextArea(list) {
		    var url = $('#url').val().split("\n");
		    url.remove(list);
		    $('#url').val(url.join("\n"));
		}

		function Notify(url, i) {

		    ajaxCall = $.ajax({
		        url: '{{ url('notify/action') }}',
		        type: 'POST',
		        dataType: 'JSON',
		        data: {
		            url: url[i],
		            attacker: ($('#attacker').val().trim() !== '') ? $('#attacker').val().trim() : 'Unknown',
		            team: ($('#team').val().trim() !== '') ? $('#team').val().trim() : 'Unknown',
		            poc: $('#poc').val()
		        },
		        beforeSend: function() {
		            UpdateTextArea(url[i]);
		        },
		        success: function(x) {
		            $('#result').show();
		            i++;
		            if(x.status === 'Success') {
		            	$('#resultNotify').append('<br /><font style="color:green;">' + x.status + '</font> <i class="fa fa-arrow-right"></i> ' + x.url + ' <font style="float:right;">' + x.extra + '</font>');
		            } else if(x.status === 'Failed' || x.status === 'Error') {
		            	$('#resultNotify').append('<br /><font style="color:red;">' + x.status + '</font> <i class="fa fa-arrow-right"></i> ' + x.url + ' <font style="float:right;">' + x.extra + '</font>');
		            }
		            Notify(url, i);
		        },
		        {{--error: function(x,y,z) {
		        	console.log(y);
		            $('#result').show();
		            alert('Something Went Wrong...');
		            return false;
		        }--}}
		    });
		    
		    if (url.length < 1 || i >= url.length) {
		        ajaxCall.abort();
		        $('#url,#attacker,#team,#poc').attr('disabled', false);
		        $('#stop').attr('id', 'submit').attr('value', 'Submit');
		        alert('Task Completed...');
		        return false;
		    }
		}

		$(document).ready(function() {
		    $('#result').hide();
		    $('#stop').click(function() {
		    	$('#url,#attacker,#team,#poc').attr('disabled', false);
		    	ajaxCall.abort();
		    	$('#stop').attr('value', 'Submit');
		    	$('#stop').attr('id', 'submit');
		    });
		    $('#submit').click(function() {
		        if ($('#url').val().trim() === '') {
		            alert('No data found!');
		            return false;
		        }
		        $('#submit').attr('value', 'Stop');
		        $('#submit').attr('id', 'stop');
		        var no = 1;
		        var url = $('#url').val().split("\n");
		        $('#url').val(url.join("\n"));
		        $('#url,#attacker,#team,#poc').attr('disabled', true);
		        Notify(url, 0);
		    });
		});
	</script>
@stop