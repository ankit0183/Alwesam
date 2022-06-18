<div class="modal-header"> 
		<a href=""><button type="button" class="close">&times;</button></a>
		<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Payment History for Invoice Number')}} - {{$tbl_invoices->invoice_number}}</h4>
	</div>
	<div class="modal-body">
			<br/>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h1 class="text-center">{{ trans('app.Payment History')}}</h1>
			</div>
			<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                <thead>
					<tr>
						<th>#</th>
						<th>{{ trans('app.Payment Number')}}</th>
						<th>{{ trans('app.Payment Type')}}</th>
						<th>{{ trans('app.Payment Date')}}</th>
						<th>{{ trans('app.Amount')}} ({{getCurrencySymbols()}})</th>
					</tr>
				</thead>
                <tbody>
				<?php $total=0; $i = 1; ?>   
					@if(!empty($tbl_payment_records))
					@foreach($tbl_payment_records as $tbl_payment_recordss)
					@if($tbl_payment_recordss->amount != 0)
					<tr class="texr-left">
						<td>{{ $i }}</td>
						<td>{{ $tbl_payment_recordss->payment_number }}</td>
						<td>{{ GetPaymentMethod($tbl_payment_recordss->payment_type) }}</td>
						<td>{{ date(getDateFormat(),strtotime($tbl_payment_recordss->payment_date)) }}</td>
						<td>{{ number_format($tbl_payment_recordss->amount,2) }} <?php $total += $tbl_payment_recordss->amount; ?></td>
						
						 <?php $i++; ?>
					</tr>
					@endif
					@endforeach
					@endif
                </tbody>
            </table>
			<br/>
			<table class="table table-bordered" width="100%">
				<tr>
					<td width="80%" align="right">{{ trans('app.Total Paid')}} ({{ getCurrencySymbols()}})</td>
					<td width="20%" align="center"> {{ number_format($total,2) }}</td>
				</tr>
				<tr>
					<td width="80%" align="right">{{ trans('app.Amount Due') }} ({{ getCurrencySymbols()}})</td>
					<?php 
					$grand_total=$tbl_invoices->grand_total;
					$paid_amount=$tbl_invoices->paid_amount;
					$AmountDue = $grand_total - $paid_amount; 
					?>
					<td width="20%" align="center">{{ number_format($AmountDue,2) }}  </td>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('app.Close')}}</button>
			</div>
	</div>