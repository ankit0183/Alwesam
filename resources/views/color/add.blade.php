@extends('layouts.app')
@section('content')
<style>
.checkbox-success{
	background-color: #cad0cc!important;
	 color:red;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
	 @if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Color')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							<label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
						</div>
					</div>
				</div>
				@endif
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs" role="tablist">
					<li role="presentation" class=""><a href="{!! url('/color/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Color List')}}</a></li>
					<li role="presentation" class="active"><a href="{!! url('/color/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Color')}}</b></a></li>
				</ul>
			</div>
            <div class="clearfix"></div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form method="post" action="{!! url('color/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
								<div class="form-group has-feedback col-md-12 col-sm-12 col-xs-12">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Color Name')}} <label class="text-danger">*</label> </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" id="color" name="color"  class="form-control" placeholder="{{ trans('app.Enter Color Name')}}" maxlength="20" required>
									</div>
								</div>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success colorname">{{ trans('app.Submit')}}</button>
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
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
              </div>
          </div>
	</div>
@endif   
     
@endsection