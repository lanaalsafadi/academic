<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- Site Metas -->
    <title>EduPathway</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('images/apple-touch-icon.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="{{asset('css/versions.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- Modernizer for Portfolio -->
    <script src="{{asset('js/modernizer.js')}}"></script>

	@livewireStyles

</head>
<body class="host_version"> 

	<!-- Modal -->
	<!-- Modal -->
	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content"  >
			<div class="modal-header tit-up">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Student Login</h4>
			</div>
			<div class="modal-body customer-box" id="lana">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs">
					
					<li><a class="active" href="#Login" data-toggle="tab">Login</a></li>
					<li><a href="#Registration" data-toggle="tab">Registration</a></li>
				</ul>
			
				<!-- Tab panes -->
				<div class="tab-content" id=lana>
					<div class="tab-pane active" id="Login">
						<form role="form" class="form-horizontal"  method="POST" action="{{ route('students.login')}}">
							@csrf <!-- حماية ضد CSRF -->
							@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="email1" name="email" placeholder="email" type="email">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" type="password">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-10">
									<input type="submit" class="btn btn-light btn-radius btn-brd grd1" value="Submit">
										
									
									
								</div>
							</div>
						</form>
					

					</div>
					<div class="tab-pane" id="Registration">
						
						<form role="form" class="form-horizontal" method="POST" action="{{ route('students.register') }}">
							@csrf <!-- حماية ضد CSRF -->
							@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<!-- اسم الطالب -->
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
								</div>
							</div>
					
							<!-- البريد الإلكتروني -->
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
								</div>
							</div>
					<!-- كلمة المرور -->
					<div class="form-group">
						<div class="col-sm-12">
							<input class="form-control" id="password" name="password" placeholder="Password" type="password" required>
						</div>
					</div>
							
							
					
							<!-- العمر -->
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="age" name="age" placeholder="Age" type="number" required>
								</div>
							</div>
							<!-- الهاتف -->
							<div class="form-group">
								<div class="col-sm-12">
									<input class="form-control" id="phone" name="phone" placeholder="Phone" type="text" required>
								</div>
							</div>
					
					
							<!-- الجنس -->
							<div class="form-group">
								<div class="col-sm-12">
									<select class="form-control" id="gender" name="gender" required>
										<option value="">Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
								</div>
							</div>
					
							<!-- إرسال وإلغاء -->
							<div class="row">
								<div class="col-sm-10">
									<input type="submit" class="btn btn-light btn-radius btn-brd grd1" value="Submit">
									<input type="reset" class="btn btn-light btn-radius btn-brd grd1" value="Cancel">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>

    <!-- LOADER -->
	<div id="preloader">
		<div class="loader-container">
			<div class="progress-br float shadow">
				<div class="progress__item"></div>
			</div>
		</div>
	</div>
	<!-- END LOADER -->	
	
	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="index">
				<img src="{{asset('images/apple-touch-icon.png')}}" alt="" width="150px" height="55px"/>
				<strong><h1>EduPathway</h1></strong>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-host">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item "><a class="nav-link" href="index">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="about">About Us</a></li>
						<li class="nav-item">
							<a class="nav-link" href="paidprograms" >PaipPrograms </a>
						
						</li>
						<li class="nav-item">
							<a class="nav-link" href="scholarships"  >Scholarships </a>
	
						</li>
						<li class="nav-item"><a class="nav-link" href="consultation">Consultation</a></li>
						
						<li class="nav-item"><a class="nav-link" href="contact">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							@if(Auth::guard('student')->check()) 
								<!-- إذا كان المستخدم مسجلاً -->
								<a class="hover-btn-new log orange" 
								   href="{{ route('students.logout') }}">
									<span>Logout</span>
								</a>
							@else
								<!-- إذا لم يكن المستخدم مسجلاً -->
								<a class="hover-btn-new log orange" 
								   href="#" data-toggle="modal" data-target="#login">
									<span>Login</span>
								</a>
							@endif
						</li>
						
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->
	
 @yield('content')
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>About EduPathway</h3>
                        </div>
                        <p>At EduPathway, we aim to support students in choosing the most suitable educational paths, including universities, specializations, and scholarships. We offer personalized consultations to help students make informed decisions that impact their academic future.</p>   
						<div class="footer-right">
							<ul class="footer-links-soi">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-github"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
							</ul><!-- end links -->
						</div>						
                    </div><!-- end clearfix -->
                </div><!-- end col -->

				<div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Information Link</h3>
                        </div>
                        <ul class="footer-links">
                            <li><a href="index">Home</a></li>
                            <li><a href="about">About Us</a></li>
                            <li><a href="paidprograms">PaipPrograms</a></li>
							<li><a href="scholarships">Scholarships</a></li>
							<li><a href="consultation">Consultation</a></li>
                        </ul><!-- end links -->
                    </div><!-- end clearfix -->
                </div><!-- end col -->
				
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Contact Details</h3>
                        </div>

                        <ul class="footer-links">
							<li><a href="mailto:contact@edupathway.com">contact@edupathway.com</a></li>
							<li><a href="https://www.edupathway.com">www.edupathway.com</a></li>
							<li>PO Box 12345, Education Hub, City Center, Country</li>
							<li>+123 456 7890</li>
						
                        </ul><!-- end links -->
                    </div><!-- end clearfix -->
                </div><!-- end col -->
				
            </div><!-- end row -->
        </div><!-- end container -->
    </footer><!-- end footer -->

    <div class="copyrights">
        <div class="container">
            <div class="footer-distributed">
                <div class="footer-center">                   
                    <p class="footer-company-name">All Rights Reserved. &copy; 2024 <a href="#">EduPathway</a> Design By :<a href="https://www.edupathway.com">EduPathway Team</a></p>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="{{asset('js/all.js')}}"></script>
    <!-- ALL PLUGINS -->
    <script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/timeline.min.js')}}"></script>
	<script>
		timeline(document.querySelectorAll('.timeline'), {
			forceVerticalMode: 700,
			mode: 'horizontal',
			verticalStartPosition: 'left',
			visibleItems: 4
		});
	</script>





<!-- الكود المخصص الخاص بك -->
<script>
    $(document).ready(function() {
        if (window.location.hash == "#Login") {
            $('.nav-tabs a[href="#Login"]').tab('show');
        }
        if (window.location.hash == "#Registration") {
            $('.nav-tabs a[href="#Registration"]').tab('show');
        }
    });
</script>

<script>
    $(document).ready(function() {
        // تحقق مما إذا كان هناك أي أخطاء
        @if ($errors->any())
            // عرض النافذة المنبثقة
            $('#login').modal('show');
        @endif

        // التنقل بين التابات بناءً على الـ hash
        if (window.location.hash == "#Login") {
            $('.nav-tabs a[href="#Login"]').tab('show');
        }
        if (window.location.hash == "#Registration") {
            $('.nav-tabs a[href="#Registration"]').tab('show');
        }
    });
</script>

@livewireScripts

</body>
</html>