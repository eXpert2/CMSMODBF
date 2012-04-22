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

<? if($catalog_id) {?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th><NOBR><a href="<?=base_url()?>admin/catalog/catalogdata/">Список каталогов</a></NOBR></th>
    	<th><NOBR><a href="<?=base_url()?>admin/catalog/catalogdata/editparams/<?=$catalog_id?>">Параметры каталога</a></NOBR></th>
    	<th><NOBR><a href="<?=base_url()?>admin/catalog/catalogdata/editparamvalues/<?=$catalog_id?>">Значения параметров каталога</a></NOBR></th>
    	<th width="100%"></th>
    </tr>
  </thead>
</table>
<? } ?>


<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form2" ') ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th colspan="4">Добавить новый параметр</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td>Название&nbsp;<input name="param_name" type="text" value="" style="width:70px;" title="Системное название поля"></td>
      <td>Заголовок&nbsp;<input name="param_title" type="text" value="" style="width:70px;" title="Выводимое название поля"></td>
      <td>
	      Тип:&nbsp;<select name="fldformtype" id="fldformtype" style="width:150px;">
                            <optgroup label="Вводные данные">
	                        <?
	                        foreach($fldformtypes as $fldformtype => $ftitle){ ?>
	                        <option value="<?=$fldformtype?>"> :: <?=$ftitle['title']?></option>
	                        <? } ?>
	                        </optgroup>
                            <optgroup label="Сводные таблицы">
	                        <?
	                        foreach($formdictables as $fldformtype => $ftitle){ ?>
	                        <option value="tableID_<?=$ftitle->id?>">Справочник :: <?=$ftitle->title?></option>
	                        <? } ?>
	                        </optgroup>
	                        </select>
	  </td>
      <td>
      <input name="catalog_id" type="hidden" value="<?=$catalog_id?>">
      <input name="add_new_catalog_param" type="submit" value="Добавить поле">
      </td>
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
    	<th width="50">Поле</th>
    	<th width="100">Тип</th>
    	<th>Заголовок</th>

    	<th>Скрыть</th>
    	<th>Удалить</th>
    	<th>Действия</th>
    </tr>
  </thead>
  <tbody>
   <? foreach($catalog_params as $param){ ?>
    <tr>
      <td><input name="param_pos[<?=$param->id?>]" type="text" value="<?=$param->pos?>" size="5"></td>
      <td><?=$param->id?></td>
      <td><?=$param->name?></td>
      <td><?if($param->param_type=='formfield') { echo $fldformtypes[$param->fldformtype]['title'];} else { $extformtables->get_where(array('id'=>$param->extformtable_id)); echo "Справочник: ".$extformtables->title; }?></td>
      <td><input name="param_title[<?=$param->id?>]" type="text" value="<?=$param->title?>" style="width:150px;"></td>
      <td><input name="param_hidden[<?=$param->id?>]"   class="hiddens" type="checkbox" value="1" <?=($param->hidden)?"checked":''; ?> ></td>
      <td><input name="param_delete[<?=$param->id?>]"   class="deletes" type="checkbox" value="1" <?=($param->deleted)?"checked":''; ?> ></td>
      <td><a href="/admin/catalog/items/<?=$catalog_id?>">товары</a></td>
    </tr>
    <? } ?>
  </tbody>
   <tfoot>
    <tr class="odd" >
    	<td colspan="7"><input name="save_catalog_param_data" type="submit" value="Сохранить список"></td>
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
    $('form.ajax-form2').ajaxForm({
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
    $('.scrollable').css({'margin':'0px 0 36px 0'});

});
</script>