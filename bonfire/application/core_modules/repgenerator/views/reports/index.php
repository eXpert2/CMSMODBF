<style>
.reportNames{
    margin: 4px;
    font-weight:bold;
}
</style>

<?php if(isset ($success) && $success!=false){ ?>
<div class="notification success fade-me">
        <div>Изменения успешно внесены</div>
</div>
<?php } elseif(isset($success) && $success==false) { ?>
<div class="notification error fade-me">
        <div>
            Отчёт не удалось сохранить, проверьте корректность полей
            <?php
            echo $error;
            //echo "<pre>";
            //print_r($_REQUEST);
            //echo "</pre>";
            ?>
        </div>
</div>

<? } ?>

<table border="1">
<tr>
<th>Форма редактирования</th>
<th>Отчёты</th>
</tr>
<tr>
<td width="80%">Новый отчёт

<?php if(isset ($error)) { ?>
<div class="notification error fade-me">
        <div>Обнаружены ошибки  <?php echo $error;?></div>
</div>

<?php
}
 echo form_open($this->uri->uri_string(), 'class="constrained"') ?> 
<fieldset style="margin-top: 0pt;width:550px;float:left;">
        <legend>Параметры отчета</legend>
        <div>
            <label for="sysname" class="block">Системное имя отчета</label>
            <input name="sysname" id="name" value="<?=$reporttpl->sysname?>" type="text">
        </div>
        <div>
            <label for="title" class="block">Название отчета</label>
            <input name="title" id="name" value="<?=$reporttpl->title?>" type="text">
        </div>


    <br style="clear:both;">

     <div class="submits">
            <br>
            <input name="submit" value="Сохранить" type="submit">
            <?php if($reporttpl->id>0){
               echo  '<input name="delete" value="Удалить" type="submit">';
            }?>
            
     </div>

<?php echo form_close(); ?> 

</td>
<td width="200">
    <div id="reportName-0" class="reportNames"><a href="/admin/reports/repgenerator/" rep_id="0">Новый отчёт</a></div>
    <?php

    foreach($allreports as $report){
    echo "<div id=\"reportName-{$report->id}\" class=\"reportNames\"><a href=\"/admin/reports/repgenerator/index/{$report->id}\" rep_id=\"{$report->id}\">{$report->title}</a></div>";
    }

?>

</td>
</tr>
</table>
