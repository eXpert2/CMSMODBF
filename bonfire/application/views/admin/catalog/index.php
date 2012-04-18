<?php echo form_open($this->uri->uri_string(), 'class="constrained"'); ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th>Название</th>
    	<th>Заголовок</th>
    	<th>Значение</th>
    	<th>Действие</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($catalog_settings as $k=>$v){ ?>
    <tr>
      <td><?=$v->name?></td>
      <td><?=$v->title?></td>
      <td><input name="set[<?=$v->name?>]" type="text" value="<?=$v->value?>"></td>
      <td></td>
    </tr>
    <? } ?>
  </tbody>
   <tfoot>
    <tr class="odd" >
    	<td colspan="4"><input name="save_catalog_settings" type="submit" value="Сохранить настройки"></td>
    </tr>
  </foot>
</table>
</form>