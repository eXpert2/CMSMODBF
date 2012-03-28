<?php
if(!isset($essence_id)){
    $essence_id=0;
}


?>
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
	if( isset($essences) ) {
		$essences = (array)$essences;
	}
	$id = isset($essences['id']) ? "/".$essences['id'] : '';
?>

<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Системное имя <span class="required">*</span>', 'sysname'); ?>
        <input id="sysname" type="text" name="sysname" maxlength="30" value="<?php echo set_value('sysname', isset($essences['sysname']) ? $essences['sysname'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Название <span class="required">*</span>', 'title'); ?>
        <input id="title" type="text" name="title" maxlength="30" value="<?php echo set_value('title', isset($essences['title']) ? $essences['title'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Описание', 'description'); ?>
        <input id="description" type="text" name="description" maxlength="100" value="<?php echo set_value('description', isset($essences['description']) ? $essences['description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Статус <span class="required">*</span>', 'status'); ?>
        <?php // Change the values in this array to populate your dropdown as required ?>
        <?php $options = array(
							  'active'    => 'Active',
							  'inactive'    => 'Inactive',
							  'deleted'    => 'Deleted'
							); ?>

        <?php echo form_dropdown('status', $options, set_value('status'))?>
</div>                                             
                        

	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Сохранить сущность" /> or <?php echo anchor(SITE_AREA .'/analytics/analytic_essences', 'Отменить'); ?>
	</div>

	<?php if (isset($packages)) : ?>
	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/delete'. $id); ?>" onclick="return confirm('Вы уверены, что хотите удалить сущность?')">Удалить сущность</a>
		
		<h3>Удаление сущности</h3>
		
		<div>Вы уверены, что хотите удалить сущность?</div>
	</div>
	<?php endif; ?>
<?php echo form_close(); ?>

   <?if($essence_id!=0): ?>         
			<br />
			<div class="box create rounded">
				<a class="button good" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/create_attr/'.$essence_id); ?>">Новый атрибут</a>

				<h3>Создать новый атрибут</h3>

				<p>Сообщение о новом атрибуте</p>
			</div>
			<br />
				<?php if (isset($attrs)  && count($attrs)) : ?>
				
					<h2>Аттибуты</h2>
	<table>
		<thead>
		<th>Название</th>
		<th>Описание</th>
		<th>Статус</th><th>Действие</th>
		</thead>
		<tbody>
<?php
foreach ($attrs as $record) : ?>
<?php $record = (array)$record;?>
			<tr>
<td><?php echo $record['title']?></td>
<td><?php echo $record['description']?></td>
<td><?php echo $record['status']?></td>

				<td><?php echo anchor(SITE_AREA .'/analytics/analytic_packages/edit_attr/'.$essence_id.'/'. $record['id'], 'Редактировать') ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
<?php endif; ?>		
