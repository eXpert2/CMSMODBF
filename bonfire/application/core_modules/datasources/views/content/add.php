<style>
input[type=text] { color:#444; width:230px;}
textarea { color:#444; width:240px; height:50px; font-size:11px;}
select { color:#444; width:250px;}
input.inpflds {width:150px;}
</style>
<?php echo form_open(SITE_AREA .'/content/datasources/add/'.$tableID, array('style' => 'padding: 0','id'=>'ffdtbl')) ?>
<table cellspacing="0" >
         <thead>
           <tr>
                <th colspan=2>Выберите источник данных:
	                <select name="tableID" id="tableID" onchange="gotoDS(this);">
	                	  <option value="0">-- Выбор --</option>
						  <? foreach($T as $table){ ?>
						  <option value="<?=$table->id?>" <? if($tableID==$table->id){ ?> selected <? } ?> ><?=$table->title?></option>
						  <? } ?>

					</select>
               <? if($tableID>0){?>&nbsp;&nbsp;
               <a href="/admin/content/datasources/index/<?=$tableID?>">Записи</a>&nbsp;&nbsp;
               <a href="/admin/content/datasources/add/<?=$tableID?>">Добавить запись</a>
               <? } ?></th>
           </tr>
        </thead>

        <tbody>
        	<tr>
                <td colspan=2>
                	 <table>
                       	<tr>
			               <td colspan=2><span style="font-size:16px;">Форма / <?=$T->title?></span> </td>
			            </tr>
		               <?
                       foreach($TableFields as $k => $fld){
                       ?>
                       <tr>
                          <td style="width:100px;"><?=$fld->fieldtitle?> (<?=$fld->fldformtype?>):</td>
                          <td>
                          <?
                          if(preg_match('/uploadify/',$fld->fldformtype))
                          {
                          echo "Возможность появится после сохранения этой записи";
                          } else {
                          echo modules::run('infoblockstables/field/index', $fld);
                          }
                          ?>
                          </td>
                       </tr>
                       <?
                       }
                       ?>

                        <tr>
                          <td></td>
                          <td>
                          	<input type="button" name="addrecordbtn" id="addrecordbtn" value="Сохранить" onclick="doformsubmit();">
                          	<input name="addrecord" type="hidden" value="1">
                          </td>
                       </tr>
                    </table>
                </td>
           </tr>
        </tbody>
</table>
<?php echo form_close(); ?>
<script>
var n = 1;
function gotoDS(sel)
{
	document.location.href='/admin/content/datasources/index/'+sel.value;
}
function doformsubmit()
{
    //if(jQuery('#newtablename').attr('value')=='' || jQuery('#newtabletitle').attr('value')=='') { alert('Введите название/заголовок таблицы'); return false; }
    f = jQuery('#ffdtbl').get(0).submit();
}
</script>


<script>
head.ready(function(){
	// Attach our check all function
	$(".check-all").click(function(){
		$("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});
});
</script>
