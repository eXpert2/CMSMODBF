<style>
input.inpflds {width:150px;}
</style>
<?php echo form_open(SITE_AREA .'/infoblocks/infoblocksdics/reclist/'.$activetbl, array('style' => 'padding: 0','id'=>'ffdtbl')) ?>
<table class="reclist" cellspacing="0">
           <tbody>
	           <tr>
	                 <td class="column-check">
	                    <input type="text" name="" value="<?=$maxid?>" style="width:20px;" readonly="readonly" />
	                </td>
	                <td>
	                  <input type="text" name="newrecord" id="newrecord" value="" style="width:200px;" />
	                </td>
	                <td width="40%">
	                	<input name="submitrecord" type="hidden" value="1">
	                   <input type="button" name="t" value="Добавить запись" onclick="if(jQuery('#newrecord').attr('value')==''){alert('Введите значение!');} else { jQuery('#ffdtbl').get(0).submit(); }" />
	                </td>
	           </tr>
        </tbody>
</table>
<?php echo form_close(); ?>

<?php echo form_open(SITE_AREA .'/infoblocks/infoblocksdics/reclist/'.$activetbl, array('style' => 'padding: 0','id'=>'ffdtbl2')) ?>
<table class="reclist" cellspacing="0">
           <thead>
            <tr>
               <th style="width: 2em">
                    <input class="check-allrec"  type="checkbox" />
                </th>
                <th>ID</th>
                <th colspan=3>
                   Записи справочника: <?=$T->title?>
                </th>
           </tr>
           </thead>
           <tbody>
           <? foreach($recordlist as $rec){ ?>
           <tr>
                 <td class="column-check">
                    <input type="checkbox" value="1" name="dodelete[<?=$rec->id?>]" />
                </td>
                <td>
                   <?=$rec->id?>
                </td>
                <td width="40%">
                   <?=$rec->title?>
                </td>
                <td style="width:200px;">
                   <input name="recname[<?=$rec->id?>]" type="text" value="<?=$rec->title?>" style="width:200px;">
                </td>
                <td width="30%">
                </td>
           </tr>
           <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <?php echo lang('bf_with_selected'); ?>:
                    <select name="action">
                        <option value='savelist'>Сохранить</option>
                        <option value='delete'>Удалить</option>
                    </select>
                    &nbsp;&nbsp;
                    <input type="submit" name="submit" value="Применить" />

                </td>
            </tr>
        </tfoot>

</table>
<?php echo form_close(); ?>



<script>
head.ready(function(){
	$(".check-allrec").click(function(){
		$("table.reclist input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});
});
</script>
