<? if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
		<div>Изменения успешно сохранены</div>
</div>
<? } elseif(isset($success) && $success==false && is_array($errorlist)) { ?>
<div class="notification error fade-me">
		<div>
            Произошла ошибка, проверьте поля
            <?
            echo implode(',',$errorlist);
            ?>
        </div>
</div>

<? } ?>


<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th colspan="3">Добавить новый</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td>Заголовок&nbsp;<input name="catalog_title" type="text" value="" size="30"></td>
      <td>
	      Родитель: <select size="1" name="parent_id">
	      		  <option value="0">Нет</option>
				  <? foreach($catalog_data as $k=>$v){
					  if($catalog_config['deep']>$v->level)
						  {
						  ?>
						  <option value="<?=$v->id?>"><?=$v->left?><?=$v->title?></option>
						  <?
						  }
				  }
				  ?>
			</select>
	  </td>
      <td><input name="add_new_catalog" type="submit" value="Добавить каталог"></td>
    </tr>

  </tbody>
</table>
<?php echo form_close(); ?>


<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th width="10">Pos</th>
    	<th width="10">ID</th>
    	<th>Заголовок</th>
    	<th>Товары</th>
    	<th width="80"><input class="check-all1" id="cheall1" type="checkbox" value="1" style="cursor:pointer;"> <label style="display:inline;cursor:pointer;width:auto;height:30px;" for="cheall1">Удалить</label></th>
    	<th width="75"><input class="check-all2" id="cheall2" type="checkbox" value="1" style="cursor:pointer;"> <label style="display:inline;cursor:pointer;width:auto;height:30px;" for="cheall2">Скрыть</label></th>
    	<th width="75">Редактировать</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($catalog_data as $k=>$v){ ?>
    <tr>
      <td><input style="text-align:center;" name="catalog_pos[<?=$v->id?>]" type="text" size="5" value="<?=$v->pos?>"></td>
      <td><?=$v->id?></td>
      <td><?=$v->left?><input name="catalog_title[<?=$v->id?>]" type="text" value="<?=$v->title?>"></td>
      <td><a href="/admin/catalog/items/catid/<?=$v->id?>">товары</a></td>
      <td><input name="catalog_delete[<?=$v->id?>]"   class="deletes" type="checkbox" value="1" <?=($v->deleted)?"checked":''; ?> ></td>
      <td><input name="catalog_hidden[<?=$v->id?>]"   class="hiddens" type="checkbox" value="1" <?=($v->hidden)?"checked":''; ?> ></td>
      <td><a href="/<?=$this->uri->uri_string()?>/editparams/<?=$v->id?>">Параметры</a></td>
    </tr>
    <? } ?>
  </tbody>
   <tfoot>
    <tr class="odd" >
    	<td colspan="7"><input name="save_catalog_data" type="submit" value="Сохранить список"></td>
    </tr>
  </foot>
</table>
<?php echo form_close(); ?>


<script>
head.ready(function(){
    // Attach our check all function
    $(".check-all1").click(function(){
        $("input.deletes").attr('checked', $(this).is(':checked'));
    });

    $(".check-all2").click(function(){
        $("input.hiddens").attr('checked', $(this).is(':checked'));
    });

    /*
        Ajax form submittal
    */
    $('form.ajax-form').ajaxForm({
        target: '.content-main',
    });

    /*
        AJAX Setup
    */
    $.ajaxSetup({cache: false});

    $('#loader').ajaxStart(function(){
        $('#loader').show();
    });

    $('#loader').ajaxStop(function(){
        $('#loader').hide();
    });

});
</script>
