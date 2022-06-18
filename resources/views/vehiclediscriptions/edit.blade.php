@extends('layouts.app')

@section('content')


 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>{{ trans('app.Edit VehicalDiscriptions')}}</h3>
              </div>

              
            </div>
          
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
                  <div class="x_title">
                     <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class=""><a href="{!! url('/vehicaldiscriptions/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.VehicalDiscriptions List')}}</a></li>

						 <li role="presentation" class=""><a href="{!! url('/vehicaldiscriptions/add')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.Add VehicalDiscriptions') }}</a></li>

            <li role="presentation" class="active"><a href="{!! url('/vehicaldiscriptions/list/edit/'.$editid)!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b> {{ trans('app.Edit VehicalDiscriptions')}}</b></a></li>
					</ul>
                    
                   
                  </div>
                 
				   <div class="x_panel">
                    <br />
                    <form action="update/{{ $vdescription->id }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                       
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehical Name <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="vehicaltypes" class="form-control col-md-7 col-xs-12" >
                           <option value="">Select Vehical name</option>
                            @if(!empty($vehicalname))
                          @foreach($vehicalname as $vehicalnames)
                             <option value="{{ $vehicalnames->id }}"
                              <?php if($vehicalnames->id==$vdescription->vehicle_id) {echo"selected";} ?>>{{ $vehicalnames->modelname }}</option>
                          @endforeach
                       @endif
                        </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehical Discriptions')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required="required" value="{{ $vdescription->vehicle_description }}" name="vehicaldescription" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                     <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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

@endsection