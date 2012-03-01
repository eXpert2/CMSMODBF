<style>
input.inpflds {width:150px;}
</style>
<?php echo form_open(SITE_AREA .'/infoblocks/infoblockstables/', array('style' => 'padding: 0','id'=>'ffdtbl')) ?>
<table cellspacing="0">
        <tbody>
            <tr>
                <th >
                    <div>
                    <table>
                       <tr>
                          <td><b>Создайте структуру таблицы БД:</b></td>
                          <td></td>
                       </tr>
                       <tr>
                          <td>Название поля (EN):</td>
                          <td><input type="text" name="fieldname" id="fieldname"></td>
                       </tr>
                       <tr>
                          <td>Заголовок поля (RU - LABEL):</td>
                          <td><input type="text" name="fieldtitle" id="fieldtitle"></td>
                       </tr>
                       <tr>
                          <td>Тип поля:</td>
                          <td><select name="filedtype" id="filedtype" style="width:230px;">

                        <?
                        array_shift($tablefields);
                        foreach($tablefields as $fieldtype => $ftitle){ ?>
                        <option value="<?=$fieldtype?>"><?=strtoupper($fieldtype)?></option>
                        <? } ?>
                        </select></td>
                       </tr>
                       <tr>
                          <td>Вид поля в форме:</td>
                          <td>
                            <select name="fldformtype" id="fldformtype" style="width:230px;">
                            <optgroup label="Вводные данные">
	                        <?
	                        foreach($fldformtypes as $fldformtype => $ftitle){ ?>
	                        <option value="<?=$fldformtype?>"> :: <?=$ftitle['title']?></option>
	                        <? } ?>
	                        </optgroup>
                            <optgroup label="Сводные таблицы">
	                        <?
	                        foreach($formdictables as $fldformtype => $ftitle){ ?>
	                        <option value="<?=$ftitle->noprefix?>_titleID"> :: <?=$ftitle->title?> : Title</option>
	                        <? } ?>
	                        </optgroup>
	                        </select>
	                      </td>
                       </tr>

                        <tr>
                          <td>Добавить поле:</td>
                          <td><input type="button" name="addf" id="addf" value="Добавить" onclick="addtf()"></td>
                       </tr>
                    </table>
                    <br>

                    <div id="addfdiv">
                    <div style="margin-top: 2px;width:100%;" id="ffd1"><input  class="inpflds" readonly="readonly" value="Название в БД">&nbsp;<input  class="inpflds" readonly="readonly" value="Заголовок поля">&nbsp;<input class="inpflds" readonly="readonly" value="Тип поля в БД">&nbsp;<input class="inpflds" readonly="readonly" value="Вид поля EXTJS">&nbsp;&nbsp;</div>
                    <div style="margin-top: 2px;width:100%;" id="ffd1"><input name="fields[]" class="inpflds" readonly="readonly" value="id">&nbsp;<input name="fieldtitles[]" class="inpflds" readonly="readonly" value="ID">&nbsp;<input name="fieldtypes[]" class="inpflds" readonly="readonly" value="idprimautoinc">&nbsp;<input name="fldformtypes[]" class="inpflds" readonly="readonly" value="AutoID">&nbsp;&nbsp;<a href="#"  onclick="alert('Это поле нельзя удалить!')">{X}</a></div>
                    <div style="margin-top: 2px;width:100%;" id="ffd1"><input name="fields[]" class="inpflds" readonly="readonly" value="title">&nbsp;<input name="fieldtitles[]" class="inpflds" readonly="readonly" value="Заголовок">&nbsp;<input name="fieldtypes[]" class="inpflds" readonly="readonly" value="varchar">&nbsp;<input name="fldformtypes[]" class="inpflds" readonly="readonly" value="text">&nbsp;&nbsp;<a href="#" onclick="alert('Это поле нельзя удалить!')">{X}</a></div>
                    </div>

                    <br>

                    </div>
                </th>
           </tr>

            <tr>
                <th >
                    Название таблицы(EN): <input type="text" name="newtablename" id="newtablename" style="width:100px;">
                    &nbsp; &nbsp;
                    Заголовок таблицы: <input type="text" name="newtabletitle" id="newtabletitle" style="width:100px;">
                    &nbsp; &nbsp;
                    <input type="button"  value="Создать таблицу" onclick="doformsubmit()" />
                	<input name="addnewtable" type="hidden" value="1">
                </th>
           </tr>
        </tbody>
</table>
<?php echo form_close(); ?>

<script>
var n = 1;
function addtf()
{
    if(jQuery('#fieldname').attr('value')=='') { alert('Введите название для поля!'); return false; }

    var s = "ffd"+n;
    var ndiv = jQuery('<div id="'+s+'" />').css('marginTop','2px');
    jQuery('#addfdiv').append(ndiv);
    ndiv.append('<input name="fields[]" class="inpflds" readonly="readonly" value="'+jQuery('#fieldname').attr('value')+'">&nbsp;<input name="fieldtitles[]" class="inpflds" readonly="readonly" value="'+jQuery('#fieldtitle').attr('value')+'">&nbsp;<input name="fieldtypes[]" class="inpflds" readonly="readonly" value="'+jQuery('#filedtype').attr('value')+'">&nbsp;<input name="fldformtypes[]" class="inpflds" readonly="readonly" value="'+jQuery('#fldformtype').attr('value')+'">&nbsp;&nbsp;<a href="#" onclick="jQuery(this).parent().remove();">{X}</a>');
    jQuery('#fieldname').attr('value','');
    jQuery('#fieldtype').attr('value','int');
    jQuery('#fieldtitle').attr('value','');
}
function doformsubmit()
{
    if(jQuery('#newtablename').attr('value')=='' || jQuery('#newtabletitle').attr('value')=='') { alert('Введите название/заголовок таблицы'); return false; }
    f = jQuery('#ffdtbl').get(0).submit();
}
</script>

<?php echo form_open(SITE_AREA .'/infoblocks/infoblockstables/', array('style' => 'padding: 0')) ?>
<table cellspacing="0">
        <thead>
            <tr>
                <th style="width: 2em">
                    <input class="check-all"  type="checkbox" />
                </th>
                <th>ID</th>
                <th style="width: 100%">Название таблицы</th>
                <th>Действие</th>
                <th>Форма</th>
                <th></th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="7">
                    <?php echo lang('bf_with_selected'); ?>:
                    <select name="action">
                        <option value='delete'>Удалить</option>
                    </select>
                    &nbsp;&nbsp;
                    <input type="submit" namve="submit" value="Применить" />

                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php $i=1; foreach ($formtables as $k=> $table) : ?>
            <tr>
                <td class="column-check">
                    <input type="checkbox" value="1" name="toaction[<?=$table;?>]" />
                </td>
                <td><?php echo $i++;?></td>
                <td><?php echo $table ?></td>
                <td><a href="/<?=SITE_AREA .'/infoblocks/infoblockstables/edit/'.$table?>">редактировать</a></td>
                <td><a href="/<?=SITE_AREA .'/infoblocks/infoblockstables/form/'.$table?>">показать</a></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo form_close(); ?>

<script>
head.ready(function(){
	// Attach our check all function
	$(".check-all").click(function(){
		$("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});
});
</script>
