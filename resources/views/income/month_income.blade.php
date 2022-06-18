@extends('layouts.app')
@section('content')

<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Accounts & Tax Rates',$userid)=='yes')
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
               <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Income')}}</span></a>
              </div>
                    @include('dashboard.profile')
            </nav>
          </div>
        </div>
              
            </div>
			 <div class="x_content">
             <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/income/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Income List')}}</a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/income/add')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Income')}}</a></li>
					
					<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/income/month_income')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i><b>{{ trans('app.Monthly Income Reports')}}</b></a></li>
			
            </ul>
			</div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <div class="x_content">
                    <form method="post" action="{{ url('/income/income_report') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
					<div class="col-md-12 col-xs-12 col-sm-12">
					  <h4><b>{{ trans('app.Income Details')}}</b></h4><hr style="margin-top:0px;">
					  <p class="col-md-12 col-xs-12 col-sm-12"></p>
					  </div>
                       
					  <div class="col-md-12 col-sm-12 col-xs-12 form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="st_date">{{ trans('app.Start Date') }} <label class="text-danger">*</label> 
                        </label>
						
                        <div class="col-md-5 col-sm-5 col-xs-12 input-group date start_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="start_date" name="start_date" class="form-control"  
                          value="{{ old('start_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required  />
                        </div>
						@if ($errors->has('start_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('start_date') }}</strong>
									</span>
								@endif
                      </div>
					  
					  
					  <div class="col-md-12 col-sm-12 col-xs-12 form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="end_date">{{ trans('app.End Date') }} <label class="text-danger">*</label> 
                        </label>
						
                        <div class="col-md-5 col-sm-5 col-xs-12 input-group date end_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="end_date" name="end_date" class="form-control"  
                          value="{{ old('end_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;"  required  />
                        </div>
						@if ($errors->has('end_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('end_date') }}</strong>
									</span>
								@endif
                      </div>
					  
					  
						
						
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-9 col-sm-9 col-xs-12 text-center">
						  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                        </div>
                      </div>

                    </form>
					</div>
                
              </div>
			  
            </div>
           </div>
		 </div>

 @else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
           
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
              </div>
          </div>
       
	</div>
	
@endif   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<!-- datetimepicker-->
	<script>
    // $('.datepicker').datetimepicker({
       // format: "<?php echo getDatepicker(); ?>",
		// autoclose: 1,
		// minView: 2,
    // });
	
	$(document).ready(function(){
	
    $(".start_date,.input-group-addon").click(function(){
			
		var dateend = $('#end_date').val('');
		
		});
		
		$(".start_date").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
		
			$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
			
			}).datetimepicker('setStartDate', startDate); 
		})
		.on('clearDate', function (selected) {
			 $('.end_date').datetimepicker('setStartDate', null);
		})
		
			$('.end_date').click(function(){
				
			var date = $('#start_date').val(); 
			if(date == '')
			{
				swal('First Select Start Date');
			}
			else{
				$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})
				
			}
			});
});	
	
</script>       
</script>
@endsection