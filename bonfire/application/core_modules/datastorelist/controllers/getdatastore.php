<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Getdatastore extends Base_Controller {

	public function index($ds)
	{
         $dstype = $ds->ds_type;

         switch($dstype)
         {
         	case"record":
         	$html  = "";
         	$html .= "<div>";
            $html .= $this->_renderRecordHtml($ds);
            $html .= "</div><div id='seldiv_{$ds->id}'>"; // holder for reselecting from ajax
            $html .= $this->_recordlist($ds);
            $html .= "</div>";
         	break;
         	case"recordlist":
            $html = $this->_renderRecordListHtml($ds);
         	break;
         	case"form":
            $html = $this->_renderRecordFormHtml($ds);
         	break;
         	case"field":
            $html = $this->_renderFieldHtml($ds);
         	break;
         }


		 // delete handler
		 $html .= "<label for=\"ds_name\" class=\"block\">Действия</label><a href=\"/admin/content/pages/edit/$ds->page_id/delete_ds/$ds->id\" onclick='confirmmes(this,event);'>Удалить</a>";

         echo $html;
         //exit();
	}

	function _recordlist($ds)
	{
		 $md5 = md5(time());
		 $table_id = $ds->extformtable_id;
		 $html = "";
         $html .="<label for=\"extformtable_record_id_$md5\" class=\"block\">Выберите запись</label>";
         $html .="<select size=\"1\" name=\"ds[$ds->id][extformtable_record_id]\" id=\"extformtable_record_id_$md5\">";

		 $query = $this->db->query("select id,fullname from ".$this->db->dbprefix."extformtables where id=?", array($table_id));
		 if($query->num_rows()>0)
		 {
         	$exttable = $query->first_row();

			$tquery = $this->db->query("select id,title from ".$exttable->fullname." order by title ASC");
         	if($tquery->num_rows()>0){
	         	foreach($tquery->result() as $k => $rec)
	         	{
                    if($ds->extformtable_record_id==$rec->id) $selected = " selected='selected' "; else $selected='';
			 		$html .="<option value=\"{$rec->id}\" $selected >{$rec->title}</option>";
			 	}
		 	}
		 }

		 $html .="</select>";
		 return $html;
		 //exit;
	}

	function _renderRecordHtml($ds)
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"extformtable_id_$ds->id\" class=\"block\">Выберите таблицу</label>";
         $html .="<select size=\"1\" name=\"ds[$ds->id][extformtable_id]\" id=\"extformtable_id_$ds->id\" onchange='loadDataStoreRecordList2(this,\"seldiv_$ds->id\")'>";

		 $query = $this->db->query("select id,title from ".$this->db->dbprefix."extformtables order by title ASC");
		 if($query->num_rows()>0)
		 {
         	foreach($query->result() as $k => $rec)
         	{
		 		if($ds->extformtable_id==$rec->id) $selected = " selected='selected' "; else $selected='';
		 		$html .="<option value=\"{$rec->id}\" $selected >{$rec->title}</option>";
		 	}
		 }

		 $html .="</select>";
		 return $html;
	}

	function _renderRecordListHtml($ds)
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"extformtable_id_$ds->id\" class=\"block\">Выберите таблицу</label>";
         $html .="<select size=\"1\" name=\"ds[$ds->id][extformtable_id]\" id=\"extformtable_id_$ds->id\">";

		 $query = $this->db->query("select id,title from ".$this->db->dbprefix."extformtables order by title ASC");
		 if($query->num_rows()>0)
		 {
         	foreach($query->result() as $k => $rec)
         	{
		 		if($ds->extformtable_id==$rec->id) $selected = " selected='selected' "; else $selected='';
		 		$html .="<option value=\"{$rec->id}\" $selected >{$rec->title}</option>";
		 	}
		 }

		 $html .="</select>";
         $html .="<label class=\"block\"><b>Постраничная навигация</b></label><br />";
		 $html .="<div><label for=\"ds_field_base_url_$ds->id\" class=\"block\">Базовое URL страницы</label>";
         $html .="<input name=\"ds[$ds->id][base_url]\" id=\"ds_field_base_url_$ds->id\" value=\"{$ds->base_url}\" type=\"text\" ></div>";
         $html .="<div><label for=\"ds_field_per_page_$ds->id\" class=\"block\">На странице записей</label>";
         $html .="<input name=\"ds[$ds->id][per_page]\" id=\"ds_field_per_page_$ds->id\" value=\"{$ds->per_page}\" type=\"text\" ></div>";
         $html .="<div><label for=\"ds_field_uri_segment_$ds->id\" class=\"block\">Сегмент URL</label>";
         $html .="<input name=\"ds[$ds->id][uri_segment]\" id=\"ds_field_uri_segment_$ds->id\" value=\"{$ds->uri_segment}\" type=\"text\" ></div>";

		 return $html;
	}

	function _renderRecordFormHtml($ds)
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"extformtable_id_$ds->id\" class=\"block\">Выберите таблицу</label>";
         $html .="<select size=\"1\" name=\"ds[$ds->id][extformtable_id]\" id=\"extformtable_id_$ds->id\">";

		 $query = $this->db->query("select id,title from ".$this->db->dbprefix."extformtables order by title ASC");
		 if($query->num_rows()>0)
		 {
         	foreach($query->result() as $k => $rec)
         	{
		 		if($ds->extformtable_id==$rec->id) $selected = " selected='selected' "; else $selected='';
		 		$html .="<option value=\"{$rec->id}\" $selected >{$rec->title}</option>";
		 	}
		 }

		 $html .="</select>";
		 return $html;
	}

	function _renderFieldHtml($ds)
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"ds_field_$ds->id\" class=\"block\">Произвольное поле</label>";
         $html .="<input name=\"ds[$ds->id][field_value]\" id=\"ds_field_$ds->id\" value=\"{$ds->field_value}\" type=\"text\" >";
		 return $html;
	}


	//--------------------------------------------------------------------


}

// End sidebar class