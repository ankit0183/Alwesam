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
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Expense')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
   </div>
   <div class="x_content">
      <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
         <li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/expense/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Expense List')}}</a></li>
         <li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/expense/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg i">&nbsp;</i><b>{{ trans('app.Add Expense')}}</b></a></li>
         <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/expense/month_expense')!!}"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Expense Reports')}}</a></li>
      </ul>
   </div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
               <form method="post" action="{{ url('/expense/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <h4><b>{{ trans('app.Expenses Details')}}</b></h4>
                     <hr style="margin-top:0px;">
                     <p class="col-md-12 col-xs-12 col-sm-12"></p>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="main_label">{{ trans('app.Main Label') }} <label class="text-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text" id="main_label" name="main_label"  class="form-control" value="" placeholder="{{ trans('app.Enter Main Label')}}" maxlength="30" required  />
                           @if ($errors->has('main_label'))
                           <span class="help-block">
                           <strong>{{ $errors->first('main_label') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">{{ trans('app.Status') }} <label class="text-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <select name="status" id="status" class="form-control" required>
                              <option value="">{{ trans('app.Select Status')}}</option>
                              <option value="1">{{ trans('app.Paid')}}</option>
                              <option value="2">{{ trans('app.Unpaid')}}</option>
                              <option value="0">{{ trans('app.Partially Paid')}}</option>
                           </select>
                           @if ($errors->has('status'))
                           <span class="help-block">
                           <strong>{{ $errors->first('status') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="date">{{ trans('app.Date') }} <label class="text-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 input-group date datepicker">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" id="date" name="date" class="form-control"  value="" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required  />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="items">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="expense_entry" style="padding:8px 0px 0px 0px;">{{trans('app.Expense Entry')}} (<?php echo getCurrencySymbols(); ?>)<label class="text-danger">*</label> </label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="number" id="expense_entry" class="form-control text-input"  value="" name="expense_entry[]" placeholder="{{ trans('app.Expense Amount')}}" maxlength="10" required>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_label">{{trans('app.Expense Label')}}</label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="expense_label" class="form-control text-input"  value="" name="expense_label[]" placeholder="{{ trans('app.Expense Entry Label')}}" maxlength="30">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="button" id="add_new_entry" class="btn btn-primary add_button" name="add_new_entry" >{{ trans('app.Add More Fields')}}</button>
                     </div>
                  </div>
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                        <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="hide copy">
            <div class="remove_fields">
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
				   <div class="col-md-6 col-sm-6 col-xs-12 form-group" style="padding-left: 0px;">
					  <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="expense_entry" style="padding:8px 0px 0px 0px;">{{trans('app.Expense Entry')}} (<?php echo getCurrencySymbols(); ?>)<label class="text-danger">*</label> </label>
					  <div class="col-md-9 col-sm-9 col-xs-12">
						 <input type="text" id="expense_entry" class="form-control text-input"  value="" name="expense_entry[]" maxlength="10" placeholder="{{ trans('app.Expense Amount')}}" required>
					  </div>
				  </div>
				   <div class="col-md-6 col-sm-6 col-xs-12 form-group ">
					  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_label">{{trans('app.Expense Label')}}</label>
					  <div class="col-md-7 col-sm-7 col-xs-12">
						 <input type="text" id="expense_label" class="form-control text-input" value="" name="expense_label[]" placeholder="{{ trans('app.Expense Entry Label')}}" maxlength="30">
					  </div>
					  <div class="col-sm-2 col-xs-2 addmoredelete">
						 <button type="button" class="btn btn-primary del" style="margin-top:0;">{{ trans('app.Delete')}}
						 </button>
					  </div>
				  </div>
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
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>	
<script>
   $(document).ready(function() {
   
        $(".add_button").click(function(){ 
            var html = $(".copy").html();
            $(".items").after(html);
        });
   
        $("body").on("click",".del",function(){ 
            $(this).parents('.remove_fields').remove();
        });
      });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
   $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
   autoclose: 1,
   minView: 2,
   });
</script>
@endsection