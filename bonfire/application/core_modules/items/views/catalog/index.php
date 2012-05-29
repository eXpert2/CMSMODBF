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


<?php echo form_open($this->uri->uri_string(), 'class="constrained" ') ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th colspan="4">Выберите каталог и действие</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
	      Каталог: <select size="1" id="catalog_id" name="catalog_id" style="width:200px;">
				   <option value="0">Выберите каталог...</option>
				  <? foreach($catalog_data as $k=>$v){
						  ?>
						  <option value="<?=$v->id?>" <? if($catalog_id==$v->id) echo "selected"; ?> ><?=$v->left?><?=$v->title?></option>
						  <?
				  }
				  ?>
			</select>
	  </td>
      <td><input name="show_catalog_items" type="button" value="Список товаров" onclick="doLoadCatalogPage()"></td>
      <td><input name="show_catalog_item_params" type="button" value="Параметры товаров" onclick="doShowItemlistParams()"></td>
      <td><input name="add_catalog_item" type="button" value="Добавить товар" onclick="doAddItemtBody();"></td>
    </tr>
  </tbody>
</table>
<?php echo form_close(); ?>

<? if($catalog_id){ ?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained" ') ?>
<table cellspacing="0"  id="additemtbody" style="display:none;">
  <tbody>
    <tr>
      <td>
	     <input name="title" type="text" value="" style="width:400px;">
	  </td>
	</tr>
	<tr>
      <td>
	     <textarea name="descr" style="width:400px; height:150px;" ></textarea>
	  </td>
	</tr>
	<tr>
      <td>
	    <label style="width:auto;" for="hiddenfld">Скрытый </label><input id="hiddenfld" name="hidden" type="checkbox" value="1">
	  </td>
	</tr>
    <tr>
     <td>
	     <input name="catalog_id" type="hidden" value="<?=$catalog_id;?>">
    	 <input name="add_catalog_item" type="submit" value="Добавить товар">
     </td>
    </tr>
  </tbody>
</table>
<?php echo form_close(); ?>
<? } ?>


<? if($catalog_items){ ?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained" ') ?>
<table cellspacing="0" id="itemlisttable">
  <thead>
    <tr class="odd" >
    	<th colspan="5">Список товаров</th>
    </tr>
     <tr class="odd" >
      <th width="10">ID</th>
      <th width="200">Название</th>
      <th width="100">Дата добавления</th>
      <th width="50">Скрыть</th>
      <th width="50">Удалить</th>
    </tr>
  </thead>
  <tbody>
<? foreach($catalog_items as $k=>$item){ ?>

		<tr>
	      <td ><?=$item->id?></td>
	      <td><a href="/admin/catalog/items/edititem/<?=$item->catalog_id?>/<?=$item->id?>"><?=$item->title?></a></td>
	      <td><?=$item->date_created?></td>
	      <td><input name="item_hidden[<?=$item->id?>]" type="hidden" value="0"><input name="item_hidden[<?=$item->id?>]" type="checkbox" value="1" <? echo ($item->hidden)?"checked":""; ?> ></td>
	      <td><input name="item_delete[<?=$item->id?>]" type="hidden" value="0"><input name="item_delete[<?=$item->id?>]" type="checkbox" value="1"></td>
		</tr>

<? } ?>

<? if($catalog_item_pages){ ?>
	<tr>
     <td colspan="5">
	    Страницы: <?=$catalog_item_pages?>
     </td>
    </tr>
<? } ?>
    <tr>
     <td colspan="5" style="text-align:right;">
	     <input name="catalog_id" type="hidden" value="<?=$catalog_id;?>">
    	 <input name="save_catalog_itemlist" type="submit" value="Сохранить список">
     </td>
    </tr>
  </tbody>
</table>
<?php echo form_close(); ?>
<? } ?>



<script>
function doLoadCatalogPage()
	{
  		document.location.href='/admin/catalog/items/catid/'+$('#catalog_id').val();
	}
function doAddItemtBody()
	{
		document.location.href='/admin/catalog/items/additem/'+$('#catalog_id').val();
	}
function doShowItemlistParams()
	{
		document.location.href='/admin/catalog/catalogdata/edititemparams/'+$('#catalog_id').val();
	}

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
