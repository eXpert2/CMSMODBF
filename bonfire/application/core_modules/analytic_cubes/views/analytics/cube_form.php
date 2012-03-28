
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs 

   $types=array(
        '0'=>'Цел.число',
        '1'=>'Параметр'
   );
	if( isset($packages) ) {
		$packages = (array)$packages;
	}
	$id = isset($packages['id']) ? "/".$packages['id'] : '';
?>

<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Системное имя <span class="required">*</span>', 'sysname'); ?>
        <input id="sysname" type="text" name="sysname" maxlength="30" value="<?php echo set_value('sysname', isset($packages['sysname']) ? $packages['sysname'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Название <span class="required">*</span>', 'title'); ?>
        <input id="title" type="text" name="title" maxlength="30" value="<?php echo set_value('title', isset($packages['title']) ? $packages['title'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Описание', 'description'); ?>
        <input id="description" type="text" name="description" maxlength="100" value="<?php echo set_value('description', isset($packages['description']) ? $packages['description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Статус <span class="required">*</span>', 'status'); ?>
        <?php // Change the values in this array to populate your dropdown as required ?>
        <?php $options = array(
							  'active'    => 'Активный',
							  'inactive'    => 'Неактивный',
							  'deleted'    => 'Удалённый'
							); ?>

        <?php echo form_dropdown('status', $options, set_value('status'))?>
</div>                                             
                        

	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Сохранить куб" /> or <?php echo anchor(SITE_AREA .'/analytics/analytic_cubes', 'Отменить'); ?>
	</div>

	<?php if (isset($packages)) : ?>
	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_cubes/delete'. $id); ?>" onclick="return confirm('Вы уверены, что хотите удалить куб?')">Удалить куб</a>
		
		<h3>Удаления куба</h3>
		
		<div>Вы уверены, что хотите удалить куб?</div>
	</div>
    
	<?php endif; ?>
    
<?php echo form_close(); ?>
	<br />
<?php echo form_open(SITE_AREA .'/analytics/analytic_cubes/saveExis/'.$packages['id'].'/', 'class="constrained ajax-form"'); ?>
				
					<h2>Измерения</h2>
	<table>
		<thead>
		<th>Cистемное имя</th>
		<th>Название</th>
		<th>Тип</th>
		<th>Статус</th><th>Удалить</th>
		</thead>
		<tbody>
        <tr>
            <td>
            <input id="sysname_new" type="text" name="sysname_new" maxlength="30" value=""  /></td>
            <td><input id="title_new" type="text" name="title_new" maxlength="30" value=""  /></td>
            <td><?php echo form_dropdown('type_new', $types, set_value('type'))?></td>
            <td><?php echo form_dropdown('status_new', $options, set_value('status'))?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="7" style="text-align: left;">
        <?php echo form_label('Описание <span class="required">*</span>', 'description'); ?><br />
            <textarea id="description" name="description_new" style="width: 100%;height: 50px;"></textarea>
         </td>
        </tr>
        <tr>
        <td colspan="7" style="text-align: right;"><input type="submit" name="saveexis" value="Сохранить ось" /> </td>
        </tr>

				<?php if (isset($subrecords)  && count($subrecords)) : ?>
<?php
foreach ($subrecords as $record) : ?>
<?php $record = (array)$record;?>
          <tr>
            <td>
            <input id="sysname" type="text" name="axis[<?php echo $record['id'];?>][sysname]" maxlength="30" value="<?php echo set_value('sysname', isset($record['sysname']) ? $record['sysname'] : ''); ?>"  /></td>
            <td><input id="title" type="text" name="axis[<?php echo $record['id'];?>][title]" maxlength="30" value="<?php echo set_value('title', isset($record['title']) ? $record['title'] : ''); ?>"  /></td>
            <td><?php echo form_dropdown('axis['.$record['id'].'][type]', $types, set_value('type',$record['type']))?></td>
            <td><?php echo form_dropdown('axis['.$record['id'].'][status]', $options, set_value('status',$record['status']))?></td>
         <td>
         <input type="checkbox" name="axis[<?php echo $record['id'];?>][delete]" value="1" />
         </td>
        </tr>
        <tr>
        <td colspan="7" style="text-align: left;">
        <?php echo form_label('Описание <span class="required">*</span>', 'description'); ?><br />
            <textarea id="description" name="axis[<?php echo $record['id'];?>][description]" style="width: 100%;height: 50px;"><?php echo set_value('description', isset($record['description']) ? $record['description'] : ''); ?></textarea>
         </td>
        </tr>
<?php endforeach; ?>
				<?php endif; ?>
        <td colspan="7" style="text-align: right;"><input type="submit" name="saveexises" value="Сохранить изменения" /> </td>
        </tr>
</tbody>
	</table>
<?php echo form_close(); ?>

