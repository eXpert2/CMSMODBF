<script type="text/javascript">
$(document).ready(function(){
$('.list-view .list-item').click(function() {
	$('#content').load('<?php echo site_url(SITE_AREA .'/analytics/analytic_packages/edit/') ?>/'+ $(this).attr('data_id'));
     return false;
});    
});
</script>

<div class="view split-view">
	
	<!-- Package List -->
	<div class="view">
	<?php //print_r($records);?>
	<?php if (isset($records)  && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data_id="<?php echo $record['id']; ?>">
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
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_packages/create'); ?>">Новый пакет</a>

				<h3>Создать новый пакет</h3>

				<p>Сообщение о новом пакете</p>
			</div>
			<br />
				<?php if (isset($records)  && count($records)) : ?>
				
					<h2>Пакеты</h2>
	<table>
		<thead>
		<th>Название</th>
		<th>Описание</th>
		<th>Статус</th><th>Действие</th>
		</thead>
		<tbody>
<?php
foreach ($records as $record) : ?>
<?php $record = (array)$record;?>
			<tr>
<td><?php echo $record['title']?></td>
<td><?php echo $record['description']?></td>
<td><?php echo $record['status']?></td>

				<td><?php echo anchor(SITE_AREA .'/analytics/analytic_packages/edit/'. $record['id'], 'Редактировать', 'class="ajaxify"') ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
