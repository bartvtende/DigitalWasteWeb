<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Digital Waste</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/styles.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    @yield('css')

    @yield('scripts')

	</head>
	<body>
		@yield('content')
	</body>
</html>