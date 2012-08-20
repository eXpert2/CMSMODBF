<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fncatalog extends Base_Controller {
	//--------------------------------------------------------------------
	var $mrec_counter = 0;
	var $local_deep = 1;
	var $catalog_config = array();
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('users/auth');
		//$this->auth->restrict('Site.Catalog.View'); // потребует авторизацию за просмотр
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

	function _getTree_rec($parentID,$selected,$hidden=0,$recursive=0)
	{
        if(!$hidden) $where="AND hidden=0";

		$query = $this->db->query("SELECT * FROM ".$this->db->dbprefix."catalogs WHERE `parent_id`='$parentID'  $where ORDER BY `pos`");
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
			{
                if($recursive)
		           {
	                $res2=$this->db->query("SELECT * FROM ".$this->db->dbprefix."catalogs WHERE `parent_id`=?  $where ORDER BY `pos`",array($row->id));
					$nr=$res2->num_rows();
			           if($nr>0 && $this->catalog_config['deep']>=$this->local_deep){
			           	   $this->local_deep++;
			           	   $row->sub=$this->_getTree_rec($row->id,$selected,$hidden,$recursive);
        	           }
				       if($row->id==$selected){
							$row->selected=1;
							$selected=$row->parent_id;
					   }
				   }
	          	$tree[]=$row;
			}
		}

	   return $tree;
	}


	function getcataloglist()
	{
		$args = func_get_args();
		$catalog_recursive = $args[0][0];
		$this->local_deep = 1; // обнуливаем внутренний счетчик для внешней функции
		$catalog_data = array();
        $catalog_data = @$this->_getTree_rec(0,0,1,$catalog_recursive);
        $catalog_data = @$this->_merge_rec($catalog_data,0);
        return $catalog_data;
	}

	function getcataloglistbyid()
	{
		$args = func_get_args();
		$catalog_parent_id = $args[0][0];
		$catalog_recursive = $args[0][1];
		$this->local_deep = 1; // обнуливаем внутренний счетчик для внешней функции
		$catalog_data = array();
        $catalog_data = @$this->_getTree_rec($catalog_parent_id,0,1,$catalog_recursive);
        $catalog_data = @$this->_merge_rec($catalog_data,0);
        return $catalog_data;
	}

	function getitemsbycatalogid()
	{
		$args = func_get_args();
		$ds = $args[0][0];
		$catalog_id = $ds->catalog_id;
		$catalog_recursive = $ds->recursive;
		$this->local_deep = 1; // обнуливаем внутренний счетчик для внешней функции
		$catalog_data = array();
        $catalog_data = $this->_getcatalogitems($catalog_id,$catalog_recursive);
        return $catalog_data;
	}
	//--------------------------------------------------------------------

    function _getcatalogitems($catalog_id,$catalog_recursive)
    {
        $catalog_data = $catalog_ids = array();
       	$catalog_ids[] = $catalog_id;

        if($catalog_recursive)
        {
        	$catalog_data = @$this->_getTree_rec($catalog_id,0,1,$catalog_recursive);
        	$catalog_data = @$this->_merge_rec($catalog_data,0);
        	foreach($catalog_data as $cat)
        	{
        		$catalog_ids[] = $cat->id;
        	}
        }

        //echo "<pre>";
        //print_r($catalog_ids);
        //exit;

        $catalog_id_str = implode(',',$catalog_ids);
        $itemscountquery = $this->db->query("select COUNT(id) as `countall` from `".$this->db->dbprefix."catalog_items` where `catalog_id` in (".$catalog_id_str.") AND hidden=0 ");
        $total_items_count = $itemscountquery->first_row();
        $total_items_count = $total_items_count->countall;

        $itemsquery = $this->db->query("select * from `".$this->db->dbprefix."catalog_items` where `catalog_id` in (".$catalog_id_str.") AND hidden=0 ");
        if($itemsquery->num_rows()>0)
        {
        	foreach($itemsquery->result() as $item)
        	{
        		$itemparamquery = $this->db->query("select * from  ".$this->db->dbprefix."catalog_itemparams where `catalog_id`=? AND `hidden`=0 order by `pos` ASC ",array($item->catalog_id));
        		$itemparams = $itemparamquery->result();
        		foreach($itemparams as $k=>$param)
		  		{
		            $valuequery = $this->db->query("select * from  ".$this->db->dbprefix."catalog_itemvalues where `item_id`=? AND `itemparam_id`=? ",array($item->id,$param->id));
		            if($valuequery->num_rows()>0)
		            {
		            	$param->valuedata = $valuequery->first_row();
		            	$param->value = $param->valuedata->itemvalue;
		            	$param->recfile_id = $param->valuedata->recfile_id;
		            }
		        }
		        $item->itemparams = $itemparams;
		        $items[] = $item;
        	}
        }

		//echo "<pre>";
		//print_r($items);
		//exit;
		$parent_catalog_query = $this->db->query("SELECT * FROM ".$this->db->dbprefix."catalogs WHERE id=? ",array($catalog_id));

        return array('items'=>$items, 'catalog'=>$parent_catalog_query->first_row(),'total'=>$total_items_count);

    }



}

// End Database Settings class