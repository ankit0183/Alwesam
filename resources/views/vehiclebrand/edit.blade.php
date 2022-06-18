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
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle Brand')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
				</div>
            </div>
			<div class="clearfix"></div>
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
						 
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
								<li role="presentation" class="floattab suppo_llng_li"><a href="{!! url('/vehiclebrand/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle Brand List')}}</a></li>
								<li role="presentation" class="active floattab suppo_llng_li_add"><a href="{!! url('/vehiclebrand/list/edit/'.$editid)!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Vehicle Brand')}}</b></a></li>
							</ul>
						</div>
                  
						<div class="x_panel">
							<form  action="update/{{$vehicalbrands->id}}"  method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Types')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="vehicaltypes" class="form-control col-md-7 col-xs-12" >
									   <option value="">{{ trans('app.Select Vehicle Type')}}</option>
										@if(!empty($vehicaltypes))
									  @foreach($vehicaltypes as $vehicaltypess)
										 <option value="{{ $vehicaltypess->id }}" 
										 <?php if($vehicaltypess->id==$vehicalbrands->vehicle_id) { echo"selected"; } ?>> {{ $vehicaltypess->vehicle_type }}</option>
									  @endforeach
								   @endif
									</select>
									</div>
								</div>

								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text"  required="required" name="vehicalbrand" value="{{$vehicalbrands->vehicle_brand}}" class="form-control col-md-7 col-xs-12" maxlength="30">
									</div>
								</div>
							  
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
					  
										<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
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