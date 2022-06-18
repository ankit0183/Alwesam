<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Garage Management System </title>

    <!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
	<!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
	
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	
	
	
  </head>
<style>
.nav-md .container.body .right_col {
    padding: 10px 20px 0;
     margin-left:0px; 
}
</style>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Garage Management System Wizard</h3>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- Smart Wizard -->
                    <p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                              Step 1<br />
                                              <small>Step 1 description</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                              Step 2<br />
                                              <small>Step 2 description</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                              Step 3<br />
                                              <small>Step 3 description</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                              Step 4<br />
                                              <small>Step 4 description</small>
                                          </span>
                          </a>
                        </li>
                      </ul>
						<div id="step-1">
							<form class="form-horizontal form-label-left">
								<div class="form-group">
									<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name"><h3>Database Setup</h3></div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Database Name <span class="text-danger"> *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input type="text" id="first-name" name=" " required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Database Username<span class="text-danger"> *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Database Password</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
									</div>
								</div>
								 
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Host <span class="text-danger"> *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
									</div>
								</div>
							</form>
						</div>
						
						<div id="step-2">
							<form class="form-horizontal form-label-left">
								<div class="form-group">
									<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name"><h3>System Setting</h3></div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">System Name <span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
									</div>
								</div>
							 
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">First Name <span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="birthday" class="form-control col-md-7 col-xs-12" required="required" type="text">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name<span class="text-danger"> *</span> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="birthday" class="form-control col-md-7 col-xs-12" required="required" type="text">
									</div>
								</div>
							  
							</form>
						</div>
						<div id="step-3">
							<form class="form-horizontal form-label-left">
								<div class="form-group">
									<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name"><h3>Login Details</h3></div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email<span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password<span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="text-danger"> *</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
									</div>
								</div>							  
							</form>
						</div>
						<div id="step-4">
						<form class="form-horizontal form-label-left">
							<div class="form-group">
									<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name"><h3>Please Note :</h3></div>
							</div>
							
							<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name">
								<p>
									1. It may take couple of minutes to set-up database.
								</p>
							</div>
							<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name">
								<p>
									2. Do not refresh page after to you click on install button.
								</p>
							</div>
							<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name">
								<p>
									3. You will be acknowledge with success message once after installation finishes.
								</p>
							</div>
							<div class="col-md-5 col-sm-9 col-xs-12 col-md-offset-3" for="first-name">
								<p>
									4. Click on install to complete the installation.
								</p>
							</div>
							</div>
							
						</form>
						</div>
					</div>
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       
        <!-- /footer content -->
      </div>
    </div>

<!-- jQuery -->
    
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}"></script>

    <!-- jQuery Smart Wizard -->
    <script src="{{ URL::asset('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ URL::asset('build/js/custom.min.js') }}"></script>
	
  </body>
</html>