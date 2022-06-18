<thead>
	<tr>
		
		<th class="all">{{ trans('app.Category')}}</th>
		<th class="all">{{ trans('app.Observation Point')}}</th>
		<th class="all">{{ trans('app.Comments')}}</th>
	</tr>
</thead>
<?php $i = 1; ?>									
<tbody>
<?php foreach ($data as $datas) { ?>
	<tr class="obs_point_data">
		<td><input type="text"  name="product[]" class="form-control" value="<?php echo $datas->checkout_subpoints;?>"></td>
		<td><input type="text"  name="sub_product[]" class="form-control" value="<?php echo $datas->checkout_point;?>"></td>
		<td><textarea name="comment[]" class="form-control" ></textarea> </td>
		<input type="hidden" name="obs_id[]" class="form-control" value="<?php echo $datas->id;?>">
	</tr>
<?php $i++; ?>
<?php } ?>
</tbody>