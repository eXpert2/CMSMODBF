<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict('CP.Page.View');
		$this->load->helper('config_file');
		Template::set('toolbar_title', 'Управление страницами');

    }
	//--------------------------------------------------------------------
	public function index()
	{

        $p = new Page();

        if($this->input->post('submit'))
        {
        $p->name = $this->input->post('name');
        $p->title = $this->input->post('title');
        $p->descr = $this->input->post('descr');
        $p->text = $this->input->post('text');
        $p->tplID = $this->input->post('tplID');
        $p->keywords = $this->input->post('keywords');
        $p->active = $this->input->post('active');
        $success = $p->save();
        Template::set('success', @$success);
        }
        $p->get();
        $t = new Tpl();
        Template::set('alltpl', $t->get()->all);
        Template::set('allpage', $p->all);
		Template::render();
	}

    public function edit()
    {

        $p = new Page();

        $currentpage = new Page();
        $pnow = $currentpage->where('id', $this->uri->segment(5))->get();


        $delete_ds = $this->uri->segment(6);
        if($delete_ds=='delete_ds')
        {
        	$ds_id = $this->uri->segment(7);
        	$deleted_ds = new Datastore();
        	$deleted_ds->get_where(array('id'=>$ds_id));
        	$deleted_ds->delete();
        	Template::redirect('/admin/content/pages/edit/'.$pnow->id);
        }



        if($this->input->post('submit'))
        {
        $pnow->name = $this->input->post('name');
        $pnow->title = $this->input->post('title');
        $pnow->descr = $this->input->post('descr');
        $pnow->text = $this->input->post('text');
        $pnow->tplID = $this->input->post('tplID');
        $pnow->keywords = $this->input->post('keywords');
        $pnow->active = $this->input->post('active');
        $success = $pnow->save();
        Template::set('success', @$success);
        }


        if($this->input->post('add_datastore'))
        {
         	$datastore = new Datastore();
         	$datastore->page_id =  $this->uri->segment(5);
         	$datastore->ds_type =  $this->input->post('ds_type');
         	$datastore->extformtable_id =  $this->input->post('extformtable_id');
         	$datastore->extformtable_record_id =  $this->input->post('extformtable_record_id');
         	$datastore->field_value =  $this->input->post('field_value');
         	$datastore->pos = $datastore->getMaxPos($datastore->page_id)+1;
         	$datastore->name = $datastore->ds_type.'_'.$datastore->pos;


         	switch($datastore->ds_type)
         	{
         		case"form":
         		case"recordlist":
         		$datastore->field_value = '';
         		$datastore->extformtable_record_id = 0;
         		break;
         		case"record":
         		$datastore->field_value = '';
         		if($datastore->extformtable_id=='' || $datastore->extformtable_record_id=="")
         		{
         			$datastore->ds_type='';
         		}
         		break;
         		case"field":
         		$datastore->extformtable_id =  0;
         		$datastore->extformtable_record_id = 0;
         		break;
         	}

         	if(!empty($datastore->ds_type))
         	{
         	$success = $datastore->save();
        	Template::set('success', @$success);
        	} else {
        	Template::set_message("Выберите тип источника",'error');
        	}

        }


        if($this->input->post('save_datastore_list'))
        {
        	$dslist = $this->input->post('ds');
        	//echo "<pre>";
        	//print_r($dslist);
        	//echo "</pre>";
        	if(is_array($dslist) && count($dslist)>0)
        	{
        		foreach($dslist as $dstore_id => $dstore)
        		{
        			$updateds = new Datastore();
        			$updateds->where('id', $dstore_id)->get();
        			if(is_array($dstore) && count($dstore)>0)
        			{
        				foreach($dstore as $k => $fieldname)
        				{
        					$updateds->$k = $fieldname;
        				}
                        $updateds->save();
        			}

        		}
        	}
        }




        $t = new Tpl();
        $ds = new Datastore();
        if($pnow->id>0) $ds->where('page_id',$pnow->id);
        Template::set('pagedslist', $ds->get()->all);
        Template::set('alltpl', $t->get()->all);
        Template::set('editpage', $pnow);
        Template::set('allpage', $p->get()->all);
        Template::render();
    }



	//--------------------------------------------------------------------



}

// End Database Settings class