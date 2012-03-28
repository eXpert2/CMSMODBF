
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
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
							  'active'    => 'Active',
							  'inactive'    => 'Inactive',
							  'deleted'    => 'Deleted'
							); ?>

        <?php echo form_dropdown('status', $options, set_value('status'))?>
</div>                                             
                        

	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Сохранить пакет" /> or <?php echo anchor(SITE_AREA .'/analytics/analytic_packages', 'Отменить'); ?>
	</div>

	<?php if (isset($packages)) : ?>
	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_packages/delete'. $id); ?>" onclick="return confirm('Вы уверены, что хотите удалить пакет?')">Удалить пакет</a>
		
		<h3>Удаления пакета</h3>
		
		<div>Вы уверены, что хотите удалить пакет?</div>
	</div>
	<?php endif; ?>
<?php echo form_close(); ?>
