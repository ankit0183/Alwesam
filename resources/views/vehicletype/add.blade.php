@extends('layouts.app')
@section('content')
<style>
.checkbox-success{
	background-color: #cad0cc!important;
	 color:red;
}
</style>
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
	@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
	
	<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
					  <div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle Type')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
				</div>
            </div>
			<div class="clearfix"></div>
			 @if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success danger checkbox-circle">
						 
						  <label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
						</div>
					</div>
				</div>
			@endif
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_content">
							<div class="">
								<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
									<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/vehicletype/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.VehicleType List')}}</a></li>
									<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/vehicletype/vehicletypeadd')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b> {{ trans('app.Add VehicleType')}}</b></a></li>
								</ul>
							</div>
								<div class="x_panel">
									<form action="{{ url('/vehicletype/vehicaltystore') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

									  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:30px;">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Type')}} <label class="text-danger">*</label>
										</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
										  <input type="text"  required="required" name="vehicaltype" placeholder="{{ trans('app.Enter VehicleType')}}" maxlength="30" class="form-control">
										</div>
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
    </div> 
	@else
	<div class="right_col" role="main" style="background-color: #e6e6e6;">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle titleup">
						<span>&nbsp {{ trans('app.You are not authorize this page.')}}</span>
					</div>
				</nav>
			</div>
		</div>
	</div>
	
	@endif
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
              </div>
        </div>
	</div>
@endif   
@endsection