@extends('layouts.app')
@section('content')
<style>
input[type=radio] {
    margin: 10px 0 0!important;
    margin-top: 1px\9;
    width: 25px;
    line-height: normal;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Custom Fields',$userid)=='yes')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
					  <div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp 
						{{ trans('app.Custom Field')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
					<div class="row massage">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
							
							  <label for="checkbox-10 colo_success">  {{session('message')}} </label>
							</div>
						</div>
					</div>
				@endif
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/custom/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.List Custom Field')}}</a></li>
					<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/custom/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b> {{ trans('app.Add Custom Field')}}</b></a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form method="post" action="{{ url('setting/custom/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Form Name')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control col-md-9 col-xs-12" name="formname" required>
											<option value="">{{ trans('app.Select Form Name')}}
											<option value="supplier">{{ trans('app.Supplier')}}</option>
											<option value="customer">{{ trans('app.Customer')}}</option>
											<option value="employee">{{ trans('app.Employee')}}</option>
										</select>
									</div>
								</div>
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Label')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" name="labelname" class="form-control" placeholder="{{ trans('app.Enter Label Name') }}" required value="" maxlength="20">
									</div>
								</div>
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Type')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control col-md-9 col-xs-12" name="typename" required>
											<option value="">{{ trans('app.Select Type')}}
											<option value="textbox">{{ trans('app.TextBox')}}</option>
											<option value="date">{{ trans('app.Date')}}</option>
											<option value="textarea ">{{ trans('app.Textarea')}} </option>
											
										</select>
									</div>
								</div>
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Required')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="radio"  name="required" value="yes" >{{ trans('app.Yes')}} 
										<input type="radio" name="required" checked value="no" > {{ trans('app.No')}}
									</div>
								</div>
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Always visible')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="radio"  name="visable" checked value="yes" >{{ trans('app.Yes')}} 
										<input type="radio" name="visable" value="no" > {{ trans('app.No')}}
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
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
			<div class="nav toggle" style="padding-bottom:16px;">
				<span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
			</div>
		</div>
	</div>
	
@endif   
		 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  

@endsection