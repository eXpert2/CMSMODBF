<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends Admin_Controller {
	//--------------------------------------------------------------------
	var $mrec_counter = 0;
	var $local_deep = 1;
	var $catalog_config = array();
	var $item_id = null;

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
		Template::set('toolbar_title', 'Управление товарами');

    }
	//--------------------------------------------------------------------

	public function _remap($method,$params=array())
	 {
	     if($method == 'page')
	     {
	         $this->catalog_id = (int)$this->uri->segment(5);
	     	 Template::set_view('catalog/index');
	         $this->index();
	     } elseif($method == 'catid')
	     {
	     	 $this->catalog_id = (int)$this->uri->segment(5);
	     	 Template::set_view('catalog/index');
	         $this->index();
	     } elseif(method_exists($this, $method))
	     {
	         $this->catalog_id = (int)$this->uri->segment(5);
	         return call_user_func_array(array($this, $method), $params);
	     } else
	     {
	     show_404();
	     }
	 }


	public function index()
	{

		if($this->input->post('catalog_id'))
		{
			$this->catalog_id = (int)$this->input->post('catalog_id');
		} elseif($this->catalog_id<=0)
		{
		$this->catalog_id = 0;
		}

        if($this->input->post('add_catalog_item'))
		{
			$this->catalog_id = (int)$this->input->post('catalog_id');
			if($this->catalog_id>0)
			{
    			$title = $this->input->post('title');
    			$descr = $this->input->post('descr');
    			$hidden = ($this->input->post('hidden')==1)?1:0;
                $this->db->query("insert into ".$this->db->dbprefix."catalog_items set title=?, descr=?, catalog_id=?, hidden=?, date_created=NOW() ",array($title,$descr,$this->catalog_id,$hidden));
			}
		}

		if($this->catalog_id>0)
		{
            if($this->input->post('save_catalog_itemlist'))
            {
            	$item_hidden = $this->input->post('item_hidden');
            	$item_delete = $this->input->post('item_delete');
            	if(is_array($item_hidden) && count($item_hidden)>0)
            	{
            		foreach($item_hidden as $item_id=>$val)
            			$this->db->query("update ".$this->db->dbprefix."catalog_items set hidden=? where id=?",array($val,$item_id));
            	}

            	if(is_array($item_delete) && count($item_delete)>0)
            	{
            		foreach($item_delete as $item_id=>$val)
            			if($val==1) $this->db->query("delete from ".$this->db->dbprefix."catalog_items where id=?",array($item_id));
            	}
            }


			$qnum = $this->db->query("select * from ".$this->db->dbprefix."catalog_items where catalog_id=?", array($this->catalog_id));
            $total_rows = $qnum->num_rows();

            $this->load->library('pagination');
			$config['base_url'] = base_url()."/admin/catalog/items/catid/".$this->catalog_id."/";
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $this->catalog_config['admin_itemlist_per_page'];
			$config['uri_segment'] = 6;
			$page_now = $this->uri->segment(6);
			$page_now = ($page_now<=0)?0:$page_now;



            $query = $this->db->query("select * from ".$this->db->dbprefix."catalog_items where catalog_id=? ORDER BY id ASC LIMIT ".$page_now.','.$config['per_page']." ", array($this->catalog_id));
            $catalog_items = $query->result();

            $this->pagination->initialize($config);
			Template::set('catalog_item_pages', $this->pagination->create_links());
		}




        Template::set('catalog_items', $catalog_items);



        $catalog_data = array();
        $catalog_data = @$this->_getTree_rec(0,0,1);
        $catalog_data = @$this->_merge_rec($catalog_data,0);
        Template::set('catalog_data', $catalog_data);
        Template::set('catalog_id', $this->catalog_id);
		Template::render();
	}


    function additem()
    {
    	if($this->input->post('catalog_id'))
		{
			$this->catalog_id = (int)$this->input->post('catalog_id');
		} elseif($this->catalog_id<=0)
		{
		Template::redirect('/admin/catalog/items/');
		}

        $catquery = $this->db->query("select * from ".$this->db->dbprefix."catalogs where id=?",array($this->catalog_id));
        $this->catalog_current = $catquery->first_row();
        $itemparamquery = $this->db->query("select * from  ".$this->db->dbprefix."catalog_itemparams where `catalog_id`=? AND `hidden`=0 order by `pos` ASC ",array($this->catalog_id));
        $itemparams = $itemparamquery->result();
        if($this->input->post('add_catalog_item'))
		{
    			$title = trim($this->input->post('title'));
    			if(empty($title))
    			{
    				$errorlist[] = "название товара";
    				Template::set('success', false);
    				Template::set('errorlist', $errorlist);
    			} else {
    			$descr = $this->input->post('descr');
    			$hidden = ($this->input->post('hidden')==1)?1:0;
                $this->db->query("insert into ".$this->db->dbprefix."catalog_items set title=?, descr=?, catalog_id=?, hidden=?, date_created=NOW() ",array($title,$descr,$this->catalog_id,$hidden));
                $this->item_id = $this->db->insert_id();

                foreach($itemparams as $k=>$param)
                {
                	$this->_updateItemParamValue($param,$this->input->post($param->name));
                }

                Template::set('success', true);
                Template::redirect('/admin/catalog/items/catid/'.$this->catalog_id);
                }
		}





        Template::set('itemparams', $itemparams);
		Template::set('toolbar_title', 'Добавить новый товар');
        Template::set('extformtables',  new Extformtable());

        Template::set('catalog_id', $this->catalog_id);
        Template::set('catalog_current', $this->catalog_current);
		Template::render();


    }


    function edititem()
    {
    	if($this->input->post('catalog_id'))
		{
			$this->catalog_id = (int)$this->input->post('catalog_id');
		} elseif($this->catalog_id<=0)
		{
		Template::redirect('/admin/catalog/items/');
		}

		$this->item_id = (int)$this->uri->segment(6);
		$item_query = $this->db->get_where('catalog_items',array('id'=>$this->item_id, 'catalog_id'=>$this->catalog_id));
		if($item_query->num_rows()<=0)
		{
		Template::redirect('/admin/catalog/items/catid/'.$this->catalog_id);
		}

		// Operating with selected Item Data
		$Item = $item_query->first_row();


        $catquery = $this->db->query("select * from ".$this->db->dbprefix."catalogs where id=?",array($this->catalog_id));
        $this->catalog_current = $catquery->first_row();
        $itemparamquery = $this->db->query("select * from  ".$this->db->dbprefix."catalog_itemparams where `catalog_id`=? AND `hidden`=0 order by `pos` ASC ",array($this->catalog_id));
        $itemparams = $itemparamquery->result();
        if($this->input->post('edit_catalog_item'))
		{
    			$title = trim($this->input->post('title'));
    			if(empty($title))
    			{
    				$errorlist[] = "название товара";
    				Template::set('success', false);
    				Template::set('errorlist', $errorlist);
    			} else {
    			$descr = $this->input->post('descr');
    			$hidden = ($this->input->post('hidden')==1)?1:0;
                $this->db->query("update ".$this->db->dbprefix."catalog_items set title=?, descr=?, catalog_id=?, hidden=?, date_created=NOW() where id=? ",array($title,$descr,$this->catalog_id,$hidden,$Item->id));
                $this->item_id = $Item->id;

                foreach($itemparams as $k=>$param)
                {
                	$this->_updateItemParamValue($param,$this->input->post($param->name));
                }

                Template::set('success', true);
                Template::redirect('/admin/catalog/items/edititem/'.$this->catalog_id.'/'.$this->item_id);
                }
		}

		foreach($itemparams as $k=>$param)
  		{
            $valuequery = $this->db->query("select * from  ".$this->db->dbprefix."catalog_itemvalues where `item_id`=? AND `itemparam_id`=? ",array($this->item_id,$param->id));
            if($valuequery->num_rows()>0)
            {
            	$param->valuedata = $valuequery->first_row();
            	$param->value = $param->valuedata->itemvalue;
            	$param->recfile_id = $param->valuedata->recfile_id;
            }
        }



        Template::set('Item', $Item);

        Template::set('itemparams', $itemparams);
		Template::set('toolbar_title', 'Редактирование товара');
        Template::set('extformtables',  new Extformtable());

        Template::set('catalog_id', $this->catalog_id);
        Template::set('catalog_current', $this->catalog_current);
		Template::render();


    }

    function _updateItemParamValue($param,$value)
    {

		switch($param->param_type)
		{
		case"formfield":
		switch($param->fldformtype)
		{
			case"uploadify_doc":
			case"uploadify_image":
			$param->recfile_id = $value;
			break;
			default:
			$param->recfile_id = 0;
			break;
		}
		break;
		case"extform":
		$param->extformtable_record_id = ($value<=0)?0:$value;
		break;

		}

     	$query = $this->db->get_where('catalog_itemvalues', array('item_id' => $this->item_id, 'itemparam_id'=>$param->id));
     	$param_exists  = $query->first_row();
     	$data = array(
     			'item_id' => $this->item_id,
     			'itemparam_id' => $param->id,
                'itemvalue' => $value,
                'extformtable_id' => $param->extformtable_id,
                'extformtable_record_id' => $param->extformtable_record_id,
                'recfile_id'=>$param->recfile_id
             );
     	if($param_exists->id)
     	{
     		$this->db->update('catalog_itemvalues', $data, array('id' => $param_exists->id));
     	} else {
     		$this->db->insert('catalog_itemvalues', $data);
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