<ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class=" dropdown-toggle authpic" data-toggle="dropdown" aria-expanded="false">
			@if(!empty(Auth::user()->id))
			 @if(Auth::user()->role=='admin')
				<img src="{{ URL::asset('public/admin/'.Auth::user()->image)}}" alt="admin"  width="40px" height="40px" class="img-circle">
			 @endif
			
			 @if(Auth::user()->role=='Customer')
				<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer"  width="40px" height="40px" class="img-circle">
			@endif
			
			@if(Auth::user()->role=='Supplier')
				<img src="{{ URL::asset('public/supplier/'.Auth::user()->image)}}" alt="supplier"  width="40px" height="40px" class="img-circle">
			@endif
			
			@if(Auth::user()->role=='employee')
				<img src="{{ URL::asset('public/employee/'.Auth::user()->image)}}" alt="employee"  width="40px" height="40px" class="img-circle">
			@endif
			
			@if(Auth::user()->role=='supportstaff')
				<img src="{{ URL::asset('public/supportstaff/'.Auth::user()->image)}}" alt="supportstaff"  width="40px" height="40px" class="img-circle">
			@endif
			
			@if(Auth::user()->role=='accountant')
				<img src="{{ URL::asset('public/accountant/'.Auth::user()->image)}}" alt="accountant"  width="40px" height="40px" class="img-circle">
			@endif
			
			@if(Auth::user()->role=='')
				<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer" width="40px" height="40px" class="img-circle">
			@endif
		@endif
		   
			
			@if(!empty(Auth::user()->id))
				{{ Auth::user()->name }}
				@endif
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<li><a href="{!!url('setting/profile')!!}"> {{ trans('app.Profile')}}</a></li>
		 <?php $userid=Auth::User()->id;?>
		 @if (getAccessStatusUser('Settings',$userid)=='yes')
			@if(getActiveAdmin($userid)=='yes')
				<li> <a href="{!! url('setting/general_setting/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
			@else
				<li> <a href="{!! url('setting/timezone/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
			@endif
		@endif
			<li><a href="#" onclick="event.preventDefault();document.getElementById('logout-profile').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a>
			<form id="logout-profile" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
				</form>
			</li>
		  </ul>
		</li>

</ul>