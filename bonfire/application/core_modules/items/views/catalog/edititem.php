<? if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
		<div>Изменения успешно сохранены</div>
</div>
<? } elseif(isset($success) && $success==false && is_array($errorlist)) { ?>
<div class="notification error fade-me">
		<div>
            Произошла ошибка: товар не добавлен, проверьте поле(я) -
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
    	<th colspan="4">Каталог: <a href="/admin/catalog/items/edititem/<?=$catalog_current->id?>/"><?=$catalog_current->title?></a></th>
    </tr>
  </thead>

</table>
<?php echo form_close(); ?>

<? if($catalog_id){ ?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained" ') ?>
<table cellspacing="0"  id="additemtbody">
   <thead>
    <tr class="odd" >
    	<th colspan="2">Основные поля</th>
    </tr>
  </thead>
  <tbody>
    <tr>
       <td>
	     Название товара <span style="color:red;">*</span>
	  </td>
      <td>
	     <input name="title" type="text" value="<?=$Item->title?>" style="">
	  </td>
	</tr>
	<tr>
       <td>
	     Краткое описание товара
	  </td>
      <td>
	     <textarea name="descr" style="height:50px;" ><?=$Item->descr?></textarea>
	  </td>
	</tr>
	<tr>
       <td>
	     Опции
	  </td>
      <td>
	    <label style="width:auto;" for="hiddenfld">Скрытый </label><input id="hiddenfld" name="hidden" type="checkbox" value="1" <? echo ($Item->hidden>0)?"checked":''; ?> >
	  </td>
	</tr>



<? if(is_array($itemparams) && count($itemparams))
{ ?>
 </tbody>
 <thead>
    <tr class="odd" >
    	<th colspan="2">Дополнительные поля</th>
    </tr>
 </thead>
 <tbody>
<?
 foreach($itemparams as $param){ ?>
    <tr>
      <td width="150"><?=$param->title?></td>
      <td>
      <?
      if($param->param_type=='formfield') {
      $fld = new stdClass();
      $fld->nolabel   = true;
      $fld->fieldname   = $param->name;
	  $fld->fieldtitle  = $param->title;
	  $fld->fieldvalue  = $param->value;
	  $fld->fldformtype = $param->fldformtype;
	  $fld->recfile_id  = $param->recfile_id;
	  $fld->recordtype  = 'item';
	  $fld->record_id  = $Item->id;
	  $fld->fieldtype   = 'text';
      } else {
      $extformtables->get_where(array('id'=>$param->extformtable_id));
      $fld = new stdClass();
      $fld->nolabel   = true;
      $fld->fieldname   = $param->name;
	  $fld->fieldtitle  = $param->title;
	  $fld->fieldvalue  = $param->value;
	  $fld->recordtype  = 'item';
	  $fld->record_id  = $Item->id;
	  $fld->fldformtype = $extformtables->noprefix.'_titleID';
	  $fld->fieldtype   = 'text';
      }
      echo modules::run('infoblockstables/field/index', $fld);
      ?>

      </td>

    </tr>
<?
    } // foreach
} // if
?>

    <tr>
     <td colspan="2">
	     <input name="catalog_id" type="hidden" value="<?=$catalog_id;?>">
    	 <input name="edit_catalog_item" type="submit" value="Сохранить товар">
     </td>
    </tr>
  </tbody>
</table>
<?php echo form_close(); ?>
<? } ?>



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
