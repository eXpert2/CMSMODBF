<style>
input[type=text] { color:#444; width:230px;}
textarea { color:#444; width:240px; height:50px; font-size:11px;}
select { color:#444; width:250px;}
</style>
<?php echo form_open(SITE_AREA .'/infoblocks/infoblockstables/edit/'.$activetbl, array('style' => 'padding: 0','id'=>'ffdtbl')) ?>
<table cellspacing="0">
        <tbody>

            <tr>
                <th >
                    <div>
                    <table>
                       	<tr>
			               <td colspan=2><span style="font-size:16px;">Форма / <?=$T->title?> (тестовый просмотр)</span> </td>
			            </tr>
		               <?
                       foreach($activetable as $k => $fld){
                       ?>
                       <tr>
                          <td><?=$fld->fieldtitle?> (<?=$fld->fldformtype?>):</td>
                          <td>
                          <?
                          echo modules::run('infoblockstables/testfield/index', $fld);
                          ?>
                          </td>
                       </tr>
                       <?
                       }
                       ?>

                        <tr>
                          <td></td>
                          <td><input type="button" name="addf" id="addf" value="Сохранить" onclick="debuginfo('ffdtbl')"></td>
                       </tr>
                    </table>
                   </div>
                </th>
           </tr>


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
function debuginfo(id)
	{
		alert('Форма сохранена (тест!)');
	}
</script>
