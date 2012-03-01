<? if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
		<div>Страница добавлена</div>
</div>
<? } elseif(isset($success) && $success==false) { ?>
<div class="notification error fade-me">
		<div>
            Страница не добавлена, проверьте поля
            <?
            echo "<pre>";
            print_r($_REQUEST);
            echo "</pre>";
            ?>
        </div>
</div>

<? } ?>


<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form" ') ?>
<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend>Настройки страницы</legend>
        <div>
            <label for="name" class="block">Название страницы</label>
            <input name="name" id="name" value="" type="text">
        </div>

        <div>
            <label for="title" class="block">Заголовок страницы</label>
            <input name="title" id="title" value="" type="text">
        </div>

        <div>
            <label for="descr" class="block">Описание страницы</label>
            <input name="descr" id="descr" value="" type="text">
        </div>

        <div>
            <label for="tplID" class="block">Шаблон страницы</label>

            <select name="tplID" id="tplID" style="width:63%">
            <option value="0"  selected >Нет шаблона</option>
            <? foreach($alltpl as $tpl){ ?>
            <option value="<?=$tpl->id?>"><?=$tpl->title?></option>
            <? } ?>
            </select>


        </div>

         <div>
            <label for="keywords" class="block">Ключевые слова страницы</label>
            <input name="keywords" id="keywords" value="" type="text">
        </div>

        <div>
			<label class="block">Активная?</label>
			<input name="active" id="active1" value="1" checked="checked" type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active1" class="block">Актив</label>
			<input name="active" id="active2" value="0" type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active2" class="block">Скрытая</label>
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


<script>
head.ready(function(){
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
