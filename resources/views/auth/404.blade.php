<html>
<head>
<link href="{{ URL::asset('build/css/404error.css') }}" type="text/css" rel="stylesheet" media="all">
<link href="{{ URL::asset('/build/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" media="all">
</head>
<body>
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="error-page">
  <div class="error-box">
    <div class="error-body text-center">
      <h1>404</h1>
      <h3 class="text-uppercase">Page Not Found !</h3>
      <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
      <a href="{{ URL::previous() }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to page</a> </div>
	<!-- <footer class="footer text-center">2018 © Copyright Garrage Management System.</footer> -->
  </div>
</section>
</body>
