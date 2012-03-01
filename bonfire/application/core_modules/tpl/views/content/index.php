<? if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
        <div>Шаблон добавлен</div>
</div>
<? } elseif(isset($success) && $success==false) { ?>
<div class="notification error fade-me">
        <div>
            Шаблон не добавлен, проверьте поля
            <?
            //echo "<pre>";
            //print_r($_REQUEST);
            //echo "</pre>";
            ?>
        </div>
</div>

<? } ?>

<script language="Javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript">
        // initialisation
        editAreaLoader.init({
            id: "tpl"    // id of the textarea to transform
            ,start_highlight: true    // if start with highlight
            ,allow_resize: "both"
            ,allow_toggle: true
            ,word_wrap: false
            ,language: "en"
            ,syntax: "php"
            ,width:800
            ,change_callback:'updateTArea'
            ,submit_callback:'updateTArea'

        });
</script>
<style>
.edtar {margin-left: 116px;}
.edtar label {width:70px; }
.edtar textarea {width:460px; height:300px; }
</style>

<?php echo form_open($this->uri->uri_string(), 'class="constrained"') ?>

<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend>Настройки шаблона</legend>
        <div>
            <label for="name" class="block">Название шаблона</label>
            <input name="name" id="name" value="" type="text">
        </div>

        <div>
            <label for="title" class="block">Заголовок шаблона</label>
            <input name="title" id="title" value="" type="text">
        </div>

        <div>
            <label for="descr" class="block">Описание шаблона</label>
            <input name="descr" id="descr" value="" type="text">
        </div>

         <div>
           <label for="opt" class="block">Тип шаблона</label>
           <select size="1" name="opt" id="opt" style="width:340px;">
			<? foreach($tpltypes as $k=>$v){ ?>
			 <option value="<?=$v[opt]?>"><?=$v[title]?></option>
            <? } ?>
			</select>
        </div>

        <div>
            <label for="tpl" class="block">HTML шаблона</label>
            <div class="edtar"><textarea name="tpl" id="tpl"></textarea></div>
        </div>

        <div>
            <label class="block">Активная?</label>
            <input name="active" id="active1" value="1" checked="checked" type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active1" class="block">Актив</label>
            <input name="active" id="active2" value="0" type="radio"> <label style="text-align:left;width:50px;clear:both;margin:0;padding:0;" for="active2" class="block">Скрытая</label>
        </div>
    </fieldset>
    <div style="float:right;width:190px;border:1px solid #ddd; margin-top:7px;padding-left:5px;">
    <h5>Список шаблонов</h5>
    <?
    foreach($alltpl as $pk =>$pg) {
    ?>
    <a href="/admin/content/tpl/edit/<?=$pg->id?>"><?=$pg->title?></a><br>
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

function updateTArea(v)
{
    jQuery('#'+v).attr('value',editAreaLoader.getValue(v));
}

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
