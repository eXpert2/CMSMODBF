<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        Template::set('toolbar_title', 'Каталог');

        $this->auth->restrict('Site.Catalog.View');
    }

    //--------------------------------------------------------------------

    public function index()
    {
    	if($this->input->post('save_catalog_settings'))
    	{
    		if(is_array($this->input->post('set')))
    		{
    			foreach($this->input->post('set') as $k => $v)
    			{
    				if($k=='deep' && $v>5) $v=5;
    				if($k=='deep' && $v<=0) $v=1;
    				$this->db->query("update ".$this->db->dbprefix."catalog_settings set value=? where name=?",array($v,$k));
    			}
    		}
    	}




    	$query = $this->db->query("select * from ".$this->db->dbprefix."catalog_settings order by `pos` ASC");

        Template::set('catalog_settings', $query->result());
        Template::set_view('admin/catalog/index');
        Template::render();
    }

    //--------------------------------------------------------------------


}