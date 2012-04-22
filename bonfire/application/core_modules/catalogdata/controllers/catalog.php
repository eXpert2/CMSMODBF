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
        $catalog_data = @$this->_getTree_rec(0,0,1);
        $catalog_data = @$this->_merge_rec($catalog_data,0);
        Template::set('catalog_data', $catalog_data);
		Template::render();
	}


	public function editparams()
	{
        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $ftprefix = $this->config->item('tableformprefix');

        $dictableprefix = 'formdic';
		$svodquery = $this->db->query("select * from  `bf_extformtables` where `name` LIKE '$dictableprefix%' ");

        $this->catalog_id = $this->uri->segment(5);

        $catquery = $this->db->get_where('catalogs', array('id' =>  $this->catalog_id));
		$catalog = $catquery->first_row();


        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
        Template::set('formdictables', $svodquery->result());
        Template::set('catalog_id', $this->catalog_id);



        Template::set('toolbar_title', 'Параметры каталога - '.$catalog->title);
        if($this->input->post('add_new_catalog_param') && $catalog->id)
        {

                $existsquery = $this->db->get_where('catalog_params', array('name' =>  $this->input->post('param_name'),'catalog_id'=>$catalog->id));
				$param_exist = $existsquery->num_rows();

                if($param_exist>0)
	            { // не будем добавлять не корректные поля в БД
	            	$errors[] = 'Параметр с таким названием уже добавлен в систему';
	            }

                if($catalog->id && $param_exist<=0)
                {
                $param_name = $this->input->post('param_name');
             	$param_title = $this->input->post('param_title');
             	if(!preg_match("/^([a-z0-9])+$/i",$param_name) || empty($param_name) || empty($param_title))
	            { // не будем добавлять не корректные поля в БД
	            	$errors[] = 'Название поля может содержать только английские буквы';
	            }
	                if(count($errors)<=0)
	                {
		                $fldformtype = $this->input->post('fldformtype');
		                if(array_key_exists($fldformtype,$this->fldformtypes))
		                {
		                	$param_type = 'formfield';
		                	$extformtable_id = 0;
		                } else {
		                	$param_type = 'extform';
		                	$extformtable_id = (int)array_pop(explode('_',$fldformtype));
		                	$fldformtype='';
		                }

		                $data = array(
						    'catalog_id' => $catalog->id,
						    'name' => $param_name,
						    'title' => $param_title,
						    'param_type' => $param_type,
						    'fldformtype' => $fldformtype,
						    'value' => '',
						    'extformtable_id' => $extformtable_id,
						    'extformtable_record_id' => 0,
						    'extra_data' => ''
						 );

						 $this->db->insert('catalog_params', $data);
	                }

				}

            	if(count($errors)<=0)
		        {
			        Template::set_message('Параметры сохранены','success');
			    } else {
		        	Template::set_message(implode('<br>',$errors),'error');
		        }


        }

        if($this->input->post('save_catalog_param_data'))
        {
             if(is_array($this->input->post('param_title')))
             {
             	$errorlist = array();
             	$param_title = @$this->input->post('param_title');
             	$param_delete = @$this->input->post('param_delete');
             	$param_hidden = @$this->input->post('param_hidden');
             	$param_pos = @$this->input->post('param_pos');
             	foreach($param_title as $id=>$v)
             	{
             		$title = $v;
             		$pos = $param_pos[$id];
             		$deleted = @(!$param_delete[$id])?0:1;
             		$hidden = @(!$param_hidden[$id])?0:1;

		            $this->db->query("UPDATE ".$this->db->dbprefix."catalog_params SET title=?, pos=?, deleted=?, hidden=? where id=?", array($title,$pos,$deleted,$hidden,$id));
             	}

				$q = $this->db->query("SELECT p.*,f.path FROM ".$this->db->dbprefix."catalog_params p LEFT JOIN ".$this->db->dbprefix."recfiles f ON ( f.id = p.recfile_id )  WHERE deleted =1");
				if($q->num_rows()>0)
				{
					foreach($q->result() as $param){
                          if($param->path!='')
                          {
                          $this->db->query("DELETE FROM ".$this->db->dbprefix."recfiles WHERE id=? ",array($param->recfile_id));
                          unlink(FCPATH.ltrim($param->path,'/'));
                          }
					}
					$this->db->query("DELETE FROM ".$this->db->dbprefix."catalog_params WHERE deleted=1 ");
				}


             }
        }


        $extformtables = new Extformtable();

        Template::set('extformtables', $extformtables);


        $catalog_data = array();
        $this->db->order_by('pos','asc');
        $caralog_params_query = $this->db->get_where('catalog_params', array('catalog_id' =>  $this->catalog_id));


        Template::set('catalog_params', $caralog_params_query->result());
        Template::set('catalog_data', $catalog_data);
		Template::render();
	}


	function editparamvalues()
	{
        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $ftprefix = $this->config->item('tableformprefix');

        $dictableprefix = 'formdic';
		$svodquery = $this->db->query("select * from  `bf_extformtables` where `name` LIKE '$dictableprefix%' ");

        $this->catalog_id = $this->uri->segment(5);

        $catquery = $this->db->get_where('catalogs', array('id' =>  $this->catalog_id));
		$catalog = $catquery->first_row();


        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
        Template::set('formdictables', $svodquery->result());
        Template::set('catalog_id', $this->catalog_id);



        Template::set('toolbar_title', 'Параметры каталога - '.$catalog->title);


        if($this->input->post('save_catalog_param_values'))
        {
                $params_query = $this->db->get_where('catalog_params', array('catalog_id' =>  $this->catalog_id));
             	foreach($params_query->result() as $param)
             	{
             		$param->value = $this->input->post($param->name);
             		switch($param->param_type)
             		{
             			case"formfield":
             			switch($param->fldformtype)
             			{
             				case"uploadify_doc":
             				case"uploadify_image":
             				$param->recfile_id = $this->input->post($param->name);
             				break;
             				default:
             				$param->recfile_id = 0;
             				break;
             			}
		            	$this->db->query("UPDATE `".$this->db->dbprefix."catalog_params` SET `value`=?, recfile_id=? where `name`=?", array($param->value,$param->recfile_id,$param->name));
             			break;
             			case"extform":
             			$param->extformtable_record_id = $this->input->post($param->name);
		            	$this->db->query("UPDATE `".$this->db->dbprefix."catalog_params` SET `value`=?, extformtable_record_id=? where `name`=?", array($param->value,$param->extformtable_record_id,$param->name));
             			break;

             		}

             	}
                Template::set_message('Изменения сохранены','success');
             	//exit;
        }


        $extformtables = new Extformtable();

        Template::set('extformtables', $extformtables);


        $catalog_data = array();
        $this->db->order_by('pos','asc');
        $caralog_params_query = $this->db->get_where('catalog_params', array('catalog_id' =>  $this->catalog_id));


        Template::set('catalog_params', $caralog_params_query->result());
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