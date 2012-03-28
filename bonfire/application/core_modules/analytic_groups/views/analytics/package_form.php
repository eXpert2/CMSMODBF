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

				<td><?php echo anchor(SITE_AREA .'/analytics/analytic_groups/edit/'.$package_id.'/'. $record['id'], 'Редактировать') ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>