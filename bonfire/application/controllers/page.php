<?php

class Page extends Front_Controller {

	public $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library('smarty');
		$this->data['THEME_PATH'] = "/bonfire/themes/atatonic";

	}

	protected function remapped($page)
	{
        $query = $this->db->query("select p.*,t.name AS tplname from ".$this->db->dbprefix."pages p, ".$this->db->dbprefix."tpls t where p.name=? AND p.tplID=t.id ",array($page));
        if($query->num_rows()>0)
        {
        $PageObject = $query->first_row();
        $this->data['Page'] = $PageObject;
		// getting tpl sourse
		$this->smarty->view($PageObject->tplname, $this->data); // compile tpl from db and fetch html sourse

		} else {
			// 404 error
			show_404();
		}
	}


	// rewrite controller functions by pageloader...
	public function _remap($method)
	{
		if($method=="" || empty($method)) $method="index";
		if (method_exists($this, $method))
	    {
	        return call_user_func_array(array($this, $method), $params=array());
	    } else {
	    	$this->remapped($method);
	    }
	}
}