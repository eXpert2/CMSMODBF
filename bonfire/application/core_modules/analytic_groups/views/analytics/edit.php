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
     </div>

<?php echo form_close(); ?>  

