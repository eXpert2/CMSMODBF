<?php

class Page extends Front_Controller {

	public $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
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


		$ds = new Datastore();
		$ds->where('page_id',$PageObject->id);
		$ds->order_by('pos','ASC');
        $dstores = $ds->get()->all;

		if(count($dstores)>0)
		{
			foreach($dstores as $k => $s)
			{
				$this->data[$s->name] = $dstores[$k]->data = $this->_load_datastore_by_dstype($s);
			}
		}

		$this->data['PageDSList'] =  $dstores;

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

	protected function _load_datastore_by_dstype($ds)
	{
		$return = null;
		switch($ds->ds_type)
		{
			case"record":
			$Extformtable = new Extformtable();
            $Extformtable->get_where(array('id'=>$ds->extformtable_id));
            if($Extformtable->fullname!='' && $ds->extformtable_record_id>0)
            {
            	$query = $this->db->query("select * from $Extformtable->fullname where id=?",array($ds->extformtable_record_id));
            	if($query->num_rows()>0)
            	{
            		$return = $query->first_row();
            	}

            }
			break;
			case"recordlist":
            $Extformtable = new Extformtable();
            $Extformtable->get_where(array('id'=>$ds->extformtable_id));
            if($Extformtable->fullname!='')
            {
            	$sql = "select * from $Extformtable->fullname ";
            	$query = $this->db->query($sql);
            	if($query->num_rows()>0)
            	{
                    $this->load->library('pagination');
                    $config['base_url'] = ($ds->base_url=='')?'/page/'.$this->data['Page']->name.'/':$ds->base_url;
					$config['total_rows'] = $query->num_rows();
					$config['per_page'] = ($ds->per_page=='')? 20:$ds->per_page;
                    $config['uri_segment'] = ($ds->uri_segment=='')? 3:$ds->uri_segment;
                    $ofset = (int)$this->uri->segment($config['uri_segment']);
					$this->pagination->initialize($config);
					$pages = $this->pagination->create_links();

					$pquery = $this->db->query("$sql LIMIT ".$ofset.",".$config['per_page']." ");

            		$return = array ( 'records'=>$pquery->result(), 'pages'=>$pages);
            	}

            }
			break;
			case"form":
			$return = array('form'=>$this->_renderForm($ds));
			break;
            case"field":
            $return = array('value'=>$ds->field_value);
			break;

			case"catalog":
			//echo "Каталог:";
            $cataloglist = array();
			$html = "";
		 	$cataloglist =  modules::run('catalogdata/catalog/getcataloglistbyid', array($ds->catalog_id,$ds->recursive)); // выводим данные из модуля каталог
            $return = array ('catalog'=>$cataloglist);

            //echo "<pre>";
            //print_r($cataloglist);
            //echo "</pre>";
            //exit;

			break;

			case"itemlist":
            $cataloglist = array();
			$html = "";
		 	$itemlist =  modules::run('catalogdata/catalog/getitemsbycatalogid', array($ds->catalog_id,$ds->recursive)); // выводим данные из модуля каталог
            $return = array ('itemlist'=>$itemlist);

            //echo "<pre>";
            //print_r($cataloglist);
            //echo "</pre>";
            //exit;

			break;
		}

		return $return;

	}


	protected function _renderForm($ds)
	{
		$Extformtable = new Extformtable();
        $Extformtable->get_where(array('id'=>$ds->extformtable_id));
		$query = $this->db->query("select * from ".$this->db->dbprefix."extforms where tablename=? order by ID ASC", array($Extformtable->name));
		$activetable = $query->result();
		ob_start();
		echo form_open( '/page/'.$this->data['Page']->name.'/', array('style' => 'padding: 0','id'=>'ffdtb_'.$ds->name));
		echo "<fieldset><h2>".$Extformtable->title."</h2>";
		                       foreach($activetable as $k => $fld){

		                       echo "<div class=\"form-item\">
									 	<label for=\"name\">".$fld->fieldtitle." (".$fld->fldformtype."):</label>
			                          ";
		                       echo modules::run('infoblockstables/field/index', $fld);
							   echo "</div>";
		                       }
                               echo "
	                               <input name='tableID' type=\"hidden\" value=\"$Extformtable->id\">
	                               <input type=\"submit\" name=\"form_handler_".$ds->name."\" id=\"form_handler_".$ds->name."\" value=\"Сохранить\" >
			                      </fieldset>";
		echo form_close();
		$form = ob_get_contents();
		ob_end_clean();

		return $form;

	}
} // end of class