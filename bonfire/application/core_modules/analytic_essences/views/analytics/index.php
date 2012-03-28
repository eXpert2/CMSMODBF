<?php
echo '='.SITE_AREA.'=';
if(!isset($essence_id)){
    $essence_id=0;
}


?>
<script type="text/javascript">
$(document).ready(function(){
$('.list-view .list-item').click(function() {
	$('#content').load('<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/edit/') ?>/'+ $(this).attr('data_id'));
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
					<div class="list-item  <?php echo (($record['id']==$essence_id)?'current':'')?>"  data_id="<?php echo $record['id']; ?>">
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

		<p>Отсутствуют сущности <?php echo anchor(SITE_AREA .'/analytics/analytic_essences/create', 'Новая сущность', array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
    	<!-- Role Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/create'); ?>">Новая сущность</a>

				<h3>Создать новую сущность</h3>

				<p>Сообщение о новой сущности</p>
			</div>
			<br />
   <?if($essence_id!=0): ?>         
			<div class="box create rounded">
				<a class="button good" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/edit'); ?>">Редактировать сущность</a>

				<h3>Редактировать сущность</h3>

				<p>Сообщение о редактируемой сущности</p>
			</div>
			<br />
			<div class="box create rounded">
				<a class="button good" href="<?php echo site_url(SITE_AREA .'/analytics/analytic_essences/create_attr'); ?>">Новый атрибут</a>

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

				<td><?php echo anchor(SITE_AREA .'/analytics/analytic_essences/edit_attr/'.$essence_id.'/'. $record['id'], 'Редактировать') ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
<?php endif; ?>				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
