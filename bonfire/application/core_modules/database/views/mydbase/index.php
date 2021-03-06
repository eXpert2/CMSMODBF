<br/>
<?php if (isset($tables) && is_array($tables) && count($tables) > 0) : ?>
	<?php echo form_open(SITE_AREA .'/mydbase/database/', array('style' => 'padding: 0')) ?>
	<table cellspacing="0">
		<thead>
			<tr>
				<th style="width: 2em">
					<input class="check-all" type="checkbox" />
				</th>
				<th><?php echo lang('db_table_name'); ?></th>
				<th style="width: 5.5em"># <?php echo lang('db_records'); ?></th>
				<th><?php echo lang('db_data_size'); ?></th>
				<th><?php echo lang('db_index_size'); ?></th>
				<th><?php echo lang('db_data_free'); ?></th>
				<th><?php echo lang('db_engine'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<?php echo lang('bf_with_selected'); ?>:

					<select name="action">
						<option value="backup"><?php echo lang('db_backup'); ?></option>
						<option value="repair"><?php echo lang('db_repair'); ?></option>
						<option value="optimize"><?php echo lang('db_optimize'); ?></option>
						<option>------</option>
						<option value="drop"><?php echo lang('db_drop'); ?></option>
					</select>
					&nbsp;&nbsp;
					<input type="submit" namve="submit" value="Apply" />
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($tables as $table) : ?>
			<tr>
				<td class="column-check">
					<input type="checkbox" value="<?php echo $table->Name ?>" name="checked[]" />
				</td>
				<td><?php echo $table->Name ?></td>
				<td style="text-align: center"><?php echo $table->Rows?></td>
				<td><?php echo byte_format($table->Data_length) ?></td>
				<td><?php echo byte_format($table->Index_length) ?></td>
				<td><?php echo byte_format($table->Data_free) ?></td>
				<td><?php echo $table->Engine ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo form_close(); ?>
	<?php else : ?>
		<div class="notification info">
			<p><?php echo lang('db_no_tables'); ?></p>
		</div>

	<?php endif; ?>

<script>
head.ready(function(){
	// Attach our check all function
	$(".check-all").click(function(){
		$("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});
});
</script>