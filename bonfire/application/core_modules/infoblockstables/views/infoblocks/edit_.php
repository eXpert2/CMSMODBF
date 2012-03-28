
<?php echo form_open(SITE_AREA .'/infoblocks/infoblockstables/edit/'.$activetable->id, array('style' => 'padding: 0')) ?>  
<table cellspacing="0">
        <tbody>
            <tr>
                <th >
                    Редактировать таблицу: <input type="text" name="newtablename" id="newtablename" style="width:200px;" value="<?=$activetable->name?>"> &nbsp; &nbsp;  <input type="submit" name="edittable" value="Изменить" />   
                </th>
           </tr>
        </tbody>
</table>
<?php echo form_close(); ?>       
   
<?php echo form_open(SITE_AREA .'/infoblocks/infoblockstables/', array('style' => 'padding: 0')) ?>      
<table cellspacing="0">
        <thead>
            <tr>
                <th style="width: 2em">
                    <input class="check-all" type="checkbox" />
                </th>
                <th>ID</th>      
                <th style="width: 100%">Название таблицы</th>
                <th>Действие</th>
                <th>Актив</th>
                <th></th>    
                
            </tr>
        </thead>
        <tfoot>
            <tr>
                 <td colspan="7">
                    <?php echo lang('bf_with_selected'); ?>: 
                    <select name="action">
                        <option value='delete'>Удалить</option>
                    </select> 
                    &nbsp;&nbsp;
                    <input type="submit" namve="submit" value="Применить" />
                    
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php foreach ($tables as $table) : ?>
            <tr>
                <td class="column-check">
                    <input type="checkbox" value="1" name="toaction[<?=$table->id;?>]" />
                </td>
                <td><?php echo $table->id?></td>
                <td><?php echo $table->name ?></td>
                <td><a href="/<?=SITE_AREA .'/infoblocks/infoblockstables/edit/'.$table->id?>">редактировать</a></td>
                <td></td>
                <td></td>    
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo form_close(); ?>

<script>
head.ready(function(){
	// Attach our check all function
	$(".check-all").click(function(){
		$("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});
});
</script>
