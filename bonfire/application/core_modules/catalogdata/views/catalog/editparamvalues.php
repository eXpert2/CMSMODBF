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
    	<th><NOBR><a href="<?=base_url()?>admin/catalog/catalogdata/edititemparams/<?=$catalog_id?>">Параметры товаров</a></NOBR></th>
    	<th><NOBR><a href="<?=base_url()?>admin/catalog/items/catid/<?=$catalog_id?>">Список товаров</a></NOBR></th>
    	<th width="100%"></th>
    </tr>
  </thead>
</table>
<? } ?>

<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<table cellspacing="0">
  <thead>
    <tr class="odd" >
    	<th colspan=2>Редактирование дополнительных параметров</th>
    </tr>
  </thead>
  <tbody>
   <? foreach($catalog_params as $param){ ?>
    <tr>
      <td width="150"><?=$param->title?></td>
      <td>
      <?
      if($param->param_type=='formfield') {
      $fld = new stdClass();
      $fld->nolabel     = true;
      $fld->fieldname   = $param->name;
	  $fld->fieldtitle  = $param->title;
	  $fld->fieldvalue  = $param->value;
	  $fld->fldformtype = $param->fldformtype;
	  $fld->recfile_id  = $param->recfile_id;
	  $fld->recordtype  = 'catalog';
	  $fld->record_id   = $catalog_id;
	  $fld->fieldtype   = 'text';
      } else {
      $extformtables->get_where(array('id'=>$param->extformtable_id));
      $fld = new stdClass();
      $fld->nolabel     = true;
      $fld->fieldname   = $param->name;
	  $fld->fieldtitle  = $param->title;
	  $fld->fieldvalue  = $param->value;
	  $fld->fldformtype = $extformtables->noprefix.'_titleID';
	  $fld->recordtype  = 'catalog';
	  $fld->record_id   = $catalog_id;
	  $fld->fieldtype   = 'text';
      }
      echo modules::run('infoblockstables/field/index', $fld);
      ?>

      </td>

    </tr>
    <? } ?>
  </tbody>
   <tfoot>
    <tr class="odd" >
    	<td colspan="2"><input name="save_catalog_param_values" type="submit" value="Сохранить данные"></td>
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