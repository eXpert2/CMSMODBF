<? if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
        <div>Страница сохранена</div>
</div>
<? } elseif(isset($success) && $success==false) { ?>
<div class="notification error fade-me">
        <div>
            Страница не сохранена, проверьте поля
        </div>
</div>

<? } ?>


<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend>Настройки страницы</legend>
        <div>
            <label for="name" class="block">Название страницы</label>
            <input name="name" id="name" value="<?=$editpage->name?>" type="text">
        </div>

        <div>
            <label for="title" class="block">Заголовок страницы</label>
            <input name="title" id="title" value="<?=$editpage->title?>" type="text">
        </div>

        <div>
            <label for="descr" class="block">Описание страницы</label>
            <input name="descr" id="descr" value="<?=$editpage->descr?>" type="text">
        </div>

        <div>
            <label for="tplID" class="block">Шаблон страницы</label>
            <select name="tplID" id="tplID" style="width:63%">
            <? foreach($alltpl as $tpl){ ?>
            <option value="<?=$tpl->id?>" <?if ($editpage->tplID==$tpl->id){ ?> selected <? } ?>  ><?=$tpl->title?></option>
            <? } ?>
            </select>
        </div>

         <div>
            <label for="keywords" class="block">Ключевые слова страницы</label>
            <input name="keywords" id="keywords" value="<?=$editpage->keywords?>" type="text">
        </div>

        <div>
            <label class="block">Активная?</label>
            <input name="active" id="active1" value="1" <? if($editpage->active==1) { ?> checked="checked"  <?  } ?> type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active1" class="block">Актив</label>
            <input name="active" id="active2" value="0" <? if($editpage->active==0) { ?> checked="checked"  <?  } ?> type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active2" class="block">Скрытая</label>
        </div>
        <div>
            <label class="block">Удалить?</label>
            <a href="<?=base_url()?>admin/content/pages/delete/<?=$editpage->id?>" onclick="if(confirm('Удалить?')==false) return false;">Удалить страницу</a>
        </div>
    </fieldset>

    <div style="float:right;width:190px;border:1px solid #ddd; margin-top:7px;padding-left:5px;">
    <h5>Список страниц</h5>
    <?
    foreach($allpage as $pk =>$pg) {
    ?>
   <a href="/admin/content/pages/edit/<?=$pg->id?>"><?=$pg->title?></a><br>
    <?
    }
    ?>
    </div>
    <br style="clear:both;">

     <div class="submits">
            <br>
            <input name="submit" value="Сохранить" type="submit">
     </div>
<?php echo form_close(); ?>


<!-- /*#########ADD_DATASTORE###########*/ -->
 <?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend>Добавить источник данных</legend>
        <div>
            <label for="ds_type" class="block">Тип источника данных</label>
            <select size="1" name="ds_type" id="ds_type" onchange="loadDataStoreList(this);">
			  <option value="">Выберите тип</option>
			  <option value="recordlist">Список записей из таблицы</option>
			  <option value="record">Запись из таблицы</option>

			  <option value="catalog">Список каталогов</option>
			  <option value="itemlist">Список товаров</option>
			  <option value="item">Объект из каталога</option>

			  <option value="field">Произвольное поле</option>
			  <option value="form">Форма из таблицы</option>
			</select>
        </div>

        <div class="dslist" id="ds_loader"></div>
         <div class="dsrecordlist" id="dsrecord_loader"></div>
        <br />
        <input name="add_datastore" value="Добавить" type="submit">

    </fieldset>
<?php echo form_close(); ?>
<!-- /*###########################*/ -->


<? if(count($pagedslist)>0){ ?>
<!-- /*##########LIST_DATASTORE#########*/ -->
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<? foreach($pagedslist as $k => $ds){ ?>
<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend><?
            switch($ds->ds_type)
            {
            	case"record": echo "Запись из таблицы";				break;
            	case"recordlist": echo "Список записей из таблицы";	break;

            	case"catalog": echo "Список каталогов";	break;
            	case"itemlist": echo "Список товаров";	break;
            	case"item": echo "Объект из каталога";	break;

            	case"field": echo "Произвольное поле";				break;
            	case"form": echo "Форма из таблицы";				break;
            }

            ?></legend>

            <div>
            <label for="id_ds<?=$ds->id;?>" class="block">Параметр</label><input name="ds[<?=$ds->id;?>][name]" id="id_ds<?=$ds->id;?>" type="text" value="<?=$ds->name;?>">&nbsp;
            </div>
            <?
            echo modules::run('datastorelist/getdatastore/index', $ds);
            ?>
	        <br />

    </fieldset>

<? } ?>
<fieldset style="margin-top: 0pt;width:550px;float:left;">
	<div><input name="save_datastore_list" value="Сохранить" type="submit"> </div>
</fieldset>
<?php echo form_close(); ?>
<!-- /*###########################*/ -->
<? } ?>



<script>

function confirmmes(a,e)
{
	if(confirm('Удалить?')==true)
	{
		document.location.href=$(a).attr('href');
	}
	e.preventDefault();
}

function loadDataStoreList(sel)
{
    $('.dslist').hide();
	$('.dsrecordlist').hide();
    $.ajax({
    url:'/datastorelist/datastorelist',
    data:{
    	dstype:sel.value
    },
    success:function(t){
    	//alert(t);
    	$('#ds_loader').html(t);
    }
    });
    $('.dslist').show();
}


function loadDataStoreRecordList(sel)
{
    //$('.dslist').hide();
	$('.dsrecordlist').hide();
    $.ajax({
    url:'/datastorelist/datastorelist/recordlist',
    data:{
    	table_id:sel.value
    },
    success:function(t){
    	//alert(t);
    	$('#dsrecord_loader').html(t);
    }
    });
    $('.dsrecordlist').show();
}

function loadDataStoreRecordList2(sel,id)
{
    $.ajax({
    url:'/datastorelist/datastorelist/recordlist',
    data:{
    	table_id:sel.value
    },
    success:function(t){
    	$('#'+id).html(t);
    }
    });
}

head.ready(function(){

	$('.dslist').hide();
	$('.dsrecordlist').hide();

    // Attach our check all function
    $(".check-all").click(function(){
        $("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
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
