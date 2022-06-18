@extends('layouts.app')
@section('content')
				<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Accountants',$userid)=='yes')
        <div class="right_col" role="main">
          <div class="">
           <div class="page-title">
               <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Accountant')}}</span></a>
              </div>
              @include('dashboard.profile')
            </nav>
          </div>
        </div>
            </div>
              @if(session('message'))
				<div class="row massage">
			 <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
                 
					@if(session('message') == 'Successfully Submitted')
						<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
					@elseif(session('message')=='Successfully Updated')
						<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
					@elseif(session('message')=='Successfully Deleted')
						<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
					@endif
                </div>
				</div>
				</div>
		@endif
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_content">
                   <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
							<li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('/accountant/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Accountant List') }}</b></a></li>
						@if(!empty(getActiveCustomer($userid)=='yes'))
							<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/accountant/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Accountant') }}</a></li>
						@endif
            </ul>
			</div>
			 <div class="x_panel bgr">
                    <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
						   <th>#</th>
						  <th>{{ trans('app.Image')}}</th>
                          <th >{{ trans('app.First Name') }}</th>
                          <th>{{ trans('app.Last Name') }}</th>
                          <th>{{ trans('app.Email') }}</th>
                          <th>{{ trans('app.Mobile Number') }}</th>
                          <th>{{ trans('app.Action')}}</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php $i=1;?>
					   @foreach($accountant as $accountants)
                        <tr>
						  
                          <td>{{ $i }}</td>
                          <td><img src="{{ url('public/accountant/'.$accountants->image) }}"  width="50px" height="50px" class="img-circle" ></td>
                          <td>{{ $accountants -> name }}</td>
                          <td>{{ $accountants -> lastname}}</td>
                          <td>{{ $accountants -> email }}</td>
                          <td>{{ $accountants -> mobile_no }}</td>
                          <td> 
							@if(!empty(getActiveCustomer($userid)=='yes'))
								<a href="{!! url('/accountant/list/'.$accountants->id) !!}">
								 <button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
								 <a href="{!! url ('/accountant/list/edit/'.$accountants->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
								<a url="{!! url('/accountant/list/delete/'.$accountants->id)!!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
							@elseif(getActiveEmployee($userid)=='yes')
								<a href="{!! url('/accountant/list/'.$accountants->id) !!}">
								 <button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
							@endif
				
						  </td>
						
						  </tr>
						  <?php $i++; ?>
                       @endforeach
                      </tbody>
                    </table>
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
        <!-- /page content -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
<!-- delete accountant -->
<script>
 $('body').on('click', '.sa-warning', function() {
	
	  var url =$(this).attr('url');
	  
	  
        swal({   
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
			window.location.href = url;
             
        });
    }); 
 
</script>

@endsection