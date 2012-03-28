<script type="text/javascript">
$(document).ready(function(){
$('.list-view .list-item').click(function() {
	$('#content').load('<?php echo site_url(SITE_AREA .'/analytics/analytic_groups/edit/') ?>/'+ $(this).attr('data_id'));
     return false;
});    
});
</script>

<?php

	if( isset($package_id) ) {
		$package_id = (int)$package_id;
	}else{
	   $package_id=0;
	}

?>
<div class="view split-view">
	
	<!-- Package List -->
	<div class="view">
	<?php //print_r($records);?>
	<?php if (isset($records)  && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item  <?php echo (($record['id']==$package_id)?'current':'')?>" data_id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo $record['title']; ?></b><br/>
							<span class="small"><?php echo $record['description']; ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p>Отсутствуют пакеты выборок <?php echo anchor(SITE_AREA .'/analytics/analytic_packages/create', 'Новый пакет', array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
    	<!-- Role Editor -->
	<div id="content" class="view">
    
		<div class="scrollable" id="ajax-content">
<?php
    if($package_id==0):
?>
	<div class="notification attention">
		<p>Не выбран пакет. Выберите необходимый пакет или <?php echo anchor(SITE_AREA .'/analytics/analytic_packages/create', 'создайте его', array("class" => "ajaxify")) ?></p>
	</div>

<?php  else: ?>

<?php
	if( isset($package_id) ) {
		$package_id = (int)$package_id;
	}else{
	   $package_id=0;
	}


?>


<div class="box create rounded">
				<a class="button good" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_groups/create/'.$package_id); ?>">Новая группа</a>

				<h3>Создать новую группу</h3>

				<p>Сообщение о новой группе</p>
			</div>
			<br />
				<?php if (isset($groups)  && count($groups)) : ?>
				
					<h2>Группы</h2>
	<table>
		<thead>
		<th>Название</th>
		<th>Описание</th>
		<th>Статус</th><th>Действие</th>
		</thead>
		<tbody>
<?php
foreach ($groups as $record) : ?>
<?php $record = (array)$record;?>
			<tr>
<td><?php echo $record['title']?></td>
<td><?php echo $record['description']?></td>
<td><?php echo $record['status']?></td>

				<td><?php echo anchor(SITE_AREA .'/analytics/analytic_groups/edit/'.$package_id.'/'. $record['id'], 'Редактировать', 'class="ajaxify"') ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>




<?php endif ?>				
			
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
