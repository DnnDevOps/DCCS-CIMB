<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="description" content="DNN Call Center Suite administration web application">
		<meta name="author" content="Rudi">
		<!--<link rel="icon" href="images/favicon.ico">-->
        
		<title>DNN Call Center Suite Admin {{ Config::get('constant.version') }} - <?=strip_tags($__env->yieldContent('title'))?></title>
		
		<!-- Core CSS -->
		{!! Html::style('css/style.css') !!}
		
		<!-- Custom styles -->
		@yield('styles')
	</head>
	
	<body>
		@yield('layout')
		
		<!-- Custom scripts -->
		@yield('scripts')
	</body>
</html>