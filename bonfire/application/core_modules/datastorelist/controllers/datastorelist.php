<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Datastorelist extends Base_Controller {

	public function index($context=null)
	{
         $dstype = $this->input->get('dstype');

         switch($dstype)
         {
         	case"record":
            $html = $this->_renderRecordHtml();
         	break;
         	case"recordlist":
         	case"form":
            $html = $this->_renderRecordListHtml();
         	break;
         	case"field":
            $html = $this->_renderFieldHtml();
         	break;
         }

         echo $html;
         exit();

	}

	function recordlist()
	{
		 $md5 = md5(time());
		 $table_id = (int)$this->input->get('table_id');
		 if($table_id=="") return "";
		 $html = "";
         $html .="<label for=\"extformtable_record_id_$md5\" class=\"block\">Выберите запись</label>";
         $html .="<select size=\"1\" name=\"extformtable_record_id\" id=\"extformtable_record_id_$md5\">";

		 $query = $this->db->query("select id,fullname from ".$this->db->dbprefix."extformtables where id=?", array($table_id));
		 if($query->num_rows()>0)
		 {
         	$exttable = $query->first_row();

			$tquery = $this->db->query("select id,title from ".$exttable->fullname." order by title ASC");
         	if($tquery->num_rows()>0){
	         	foreach($tquery->result() as $k => $rec)
	         	{
			 		$html .="<option value=\"{$rec->id}\">{$rec->title}</option>";
			 	}
		 	}
		 }

		 $html .="</select>";
		 echo $html;
		 exit;
	}

	function _renderRecordHtml()
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"extformtable_id_$md5\" class=\"block\">Выберите таблицу</label>";
         $html .="<select size=\"1\" name=\"extformtable_id\" id=\"extformtable_id_$md5\" onchange='loadDataStoreRecordList(this)'>";

		 $query = $this->db->query("select id,title from ".$this->db->dbprefix."extformtables order by title ASC");
		 if($query->num_rows()>0)
		 {
         	$html .="<option value=\"\">Выберите таблицу</option>";
         	foreach($query->result() as $k => $rec)
         	{
		 		$html .="<option value=\"{$rec->id}\">{$rec->title}</option>";
		 	}
		 }

		 $html .="</select>";
		 return $html;
	}

	function _renderRecordListHtml()
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"extformtable_id_$md5\" class=\"block\">Выберите таблицу</label>";
         $html .="<select size=\"1\" name=\"extformtable_id\" id=\"extformtable_id_$md5\">";

		 $query = $this->db->query("select id,title from ".$this->db->dbprefix."extformtables order by title ASC");
		 if($query->num_rows()>0)
		 {
         	foreach($query->result() as $k => $rec)
         	{
		 		$html .="<option value=\"{$rec->id}\">{$rec->title}</option>";
		 	}
		 }

		 $html .="</select>";
		 return $html;
	}

	function _renderFieldHtml()
	{
		 $md5 = md5(time());
		 $html = "";
         $html .="<label for=\"field_value_$md5\" class=\"block\">Произвольное поле</label>";
         $html .="<input name=\"field_value\" id=\"field_value_$md5\" type=\"text\" >";
		 return $html;
	}


	//--------------------------------------------------------------------


}

// End sidebar class