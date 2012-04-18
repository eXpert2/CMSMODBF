<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends Admin_Controller {
	//--------------------------------------------------------------------
	var $mrec_counter = 0;
	var $local_deep = 1;
	var $catalog_config = array();
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict('Site.Catalog.View');
		$this->load->helper('config_file');

		$settingsquery = $this->db->query("select * from ".$this->db->dbprefix."catalog_settings order by id ASC");
		if($settingsquery->num_rows()>0)
		{
			foreach($settingsquery->result() as $k=>$v)
			{
                $this->catalog_config[$v->name] = $v->value;
			}
		}

        Template::set('catalog_config', $this->catalog_config);
		Template::set('toolbar_title', 'Управление каталогом');

    }
	//--------------------------------------------------------------------
	public function index()
	{

        if($this->input->post('add_new_catalog'))
        {
             	$catalog_title = $this->input->post('catalog_title');
                $parent_id = ($this->input->post('parent_id')=="0")?0:$this->input->post('parent_id');
                $posquery = $this->db->query("select max(`pos`)+1 as `p` from ".$this->db->dbprefix."catalogs ");
                $cat = $posquery->first_row();
                $catalog_pos = ($cat->p)?$cat->p:0;

           		if($catalog_title!='')
           		{
           		$title = $catalog_title;
           		$pos = $catalog_pos;
           		$deleted = 0;
           		$hidden = 0;
            	$this->db->query("INSERT INTO ".$this->db->dbprefix."catalogs SET title=?, pos=?, deleted=?, hidden=?, parent_id=? ", array($title,$pos,$deleted,$hidden,$parent_id));
            	}

            	$this->_reindex_catalog_pos();

        }

        if($this->input->post('save_catalog_data'))
        {
             if(is_array($this->input->post('catalog_title')))
             {
             	$errorlist = array();
             	$catalog_title = @$this->input->post('catalog_title');
             	$catalog_delete = @$this->input->post('catalog_delete');
             	$catalog_hidden = @$this->input->post('catalog_hidden');
             	$catalog_pos = @$this->input->post('catalog_pos');
             	foreach($catalog_title as $id=>$v)
             	{
             		$title = $v;
             		$pos = $catalog_pos[$id];
             		$deleted = @(!$catalog_delete[$id])?0:1;
             		$hidden = @(!$catalog_hidden[$id])?0:1;

		            $this->db->query("UPDATE ".$this->db->dbprefix."catalogs SET title=?, pos=?, deleted=?, hidden=? where id=?", array($title,$pos,$deleted,$hidden,$id));
             	}
             	$this->db->query("DELETE FROM ".$this->db->dbprefix."catalogs WHERE deleted=1 ");
             }
        }



        $catalog_data = array();
        $catalog_data = $this->_getTree_rec(0,0,1);
        $catalog_data = $this->_merge_rec($catalog_data,0);
        Template::set('catalog_data', $catalog_data);
		Template::render();
	}


	function _reindex_catalog_pos()
	{
		$IDlist=array();
		$query = $this->db->query("SELECT id FROM ".$this->db->dbprefix."catalogs WHERE pos!=0 ORDER BY pos");
		if($query->num_rows()>0)
		{
			foreach($query->result() as $cat)
			{
				$IDlist[]=$cat->id;
			}
		}
		$query = $this->db->query("SELECT id FROM ".$this->db->dbprefix."catalogs WHERE pos=0 ORDER BY pos");
		if($query->num_rows()>0)
		{
			foreach($query->result() as $cat)
			{
				$IDlist[]=$cat->id;
			}
		}

		$pos=0;
		foreach($IDlist as $ID){
			$pos++;
			$this->db->query("UPDATE ".$this->db->dbprefix."catalogs SET pos='$pos' WHERE id='$ID'");
		}

	}

	function _merge_rec($arr,$level){

		$allarr=array();
	     if(is_array($arr)){
	     	foreach($arr as $el)
	     	{
	     		$el->level=$level+1;
	     		$el->left=str_repeat("&nbsp;::&nbsp;", $level);
	     		$this->mrec_counter++;
	            $allarr[$this->mrec_counter]=$el;
	            if(is_array($el->sub)){
		           	$sub=$this->_merge_rec($el->sub,$level+1);
		           	$allarr=array_merge($allarr,$sub);
	           	}
	     	}
	     }
	     return $allarr;
	}

	function _getTree_rec($parentID,$selected,$hidden=0)
	{
        if(!$hidden) $where="AND hidden=0";

		$query = $this->db->query("SELECT * FROM ".$this->db->dbprefix."catalogs WHERE `parent_id`='$parentID'  $where ORDER BY `pos`");
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
			{
                $res2=$this->db->query("SELECT * FROM ".$this->db->dbprefix."catalogs WHERE `parent_id`=?  $where ORDER BY `pos`",array($row->id));
				$nr=$res2->num_rows();
		           if($nr>0 && $this->catalog_config['deep']>=$this->local_deep){
		           	   $this->local_deep++;
		           	   $row->sub=$this->_getTree_rec($row->id,$selected,$hidden);
		           }
			       if($row->id==$selected){
						$row->selected=1;
						$selected=$row->parent_id;
				   }
	          	$tree[]=$row;
			}
		}

	   return $tree;
	}


	//--------------------------------------------------------------------

}

// End Database Settings class