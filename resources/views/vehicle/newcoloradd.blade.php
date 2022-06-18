<!--color add new-->

<tr id="color_id_<?php echo $idc;?>">
	<td>	
		<select name="color[]" class="form-control tax" id="tax_<?php echo $idc;?>" required>
			<option value="0">{{ trans('app.Select Color')}}</option>
			<?php  foreach($color as $colors) 
			{ ?>
			<option value="<?php echo $colors->id;?>"><?php echo $colors->color;?></option> 
	 <?php  } ?>
		</select>
	</td>
	<td>
		<span class="remove_color" data-id="<?php echo $idc;?>"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
	</td>
</tr>