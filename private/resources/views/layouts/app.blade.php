<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="{{ $setting->keywords }}">
		<meta name="description" content="{{ $setting->description }}">
		<meta name=copyright content="&copy; 2017 www.priv-code.com">
		<meta name=creator content=www.priv-code.com>
		<link rel="shortcut icon" type=image/x-icon href="{{ url('images/icon.png') }}">
		<title>{{ $setting->title }} | {{ $setting->subtitle  }}</title>
		<link rel="stylesheet" type="text/css" href="{{ url('css/font-awesome.min.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}" />
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div class="logo opacity">
					<img src="{{ url('images/logo.png') }}" alt="{{ $setting->title }} | {{ $setting->subtitle }}" title="{{ $setting->subtitle }}">
				</div>
				<div class="searchform" style="float:right;">
					<input value="Search..."" onfocus='this.value=""' onblur='this.value="Search..."'>
				</div>
			</div>
			<div class="clear"></div>
			@include('layouts.menu')
			@yield('content')
			@include('layouts.footer')
		</div>
		@yield('js')
	</body>
</html>