<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Сущности');  

		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		Assets::add_js($this->load->view('analytics/js', null, true), 'inline');

    }


    //--------------------------------------------------------------------
	public function create() 
	{
		if ($this->input->post('submit'))
		{
			if ($this->save_essence())
			{
				Template::set_message('Всё нормально', 'success');
				Template::redirect(SITE_AREA .'/analytics/analytic_essences');
			}
			else 
			{
				//Template::set_message('Ошибка' . $this->package_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', 'Создать новую сущность');
		Template::set_view('analytics/essence_form');
		Template::render();
	}

    public function save_essence(){
        $ap=new Analytic_essence();
        $ap2=$ap->where('id', $this->uri->segment(5))->get();
		$this->form_validation->set_rules('sysname','Имя','required|trim|xss_clean|max_length[30]');			
		$this->form_validation->set_rules('title','Название','required|trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('description','Описание','trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
		if ($this->form_validation->run() === false)
		{
			return false;
		}
			$ap2->sysname= $this->input->post('sysname');
			$ap2->title= $this->input->post('title');
			$ap2->description= $this->input->post('description');
			$ap2->status= $this->input->post('status');
		
		
			if ($ap2->save())
			{
				$return = true;
			} else
			{
				Template::set_message('Ошибка: ' . $ap2->error->string, 'error');
				$return = false;
			}
		
		return $return;
        
    }




    public function index()
    {
        $essence_id=(int)$this->uri->segment(5);
        $as=new Analytic_essence();
 
		Template::set('records', $as->get());
        if(!empty($essence_id)){
		      Template::set('essence_id', $essence_id);
              $asa=new Analytic_essence_attr();
		      Template::set('attrs', $asa->where('essence_id',$essence_id)->get());
        }
		if (!Template::get("toolbar_title"))
		{
			Template::set("toolbar_title", 'Управление сущностями');
		}
		Template::render();
        
        
             
        }



    
	public function edit() 
	{
		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message('Неправильный id)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_essences');
		}else{
                $asa=new Analytic_essence_attr();
		      Template::set('attrs', $asa->where('essence_id',$id)->get());
  
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_essence())
			{
				Template::set_message('Всё нормально', 'success');
			}
			else 
			{
				//Template::set_message('Возникла ошибка ' . $this->permission_model->error, 'error');
			}
		}
        $ap=new Analytic_essence();
		
		Template::set('essences', $ap->where('id',$id)->get());
		Template::set('essence_id', $id);
	
		Template::set('toolbar_title','Редактирование сущности');
		Template::set_view('analytics/essence_form');
		Template::render();		
	}
    
	public function delete() 
	{	
		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
            $ap=new Analytic_essence();
            $ap2=$ap->where('id',$id)->get();
            if ($ap2->delete())
			{
				Template::set_message('Удаление сущности прошло успешно.', 'success');
			} else
			{
				Template::set_message('Возникли ошибки при удалении сущности: ' . $ap2->error->string, 'error');
			}
		}
		
		redirect(SITE_AREA .'/analytics/analytic_essences');
	}


    public function save_attr(){
        $ap=new Analytic_essence_attr();
        $essence_id=(int)$this->uri->segment(5);
        $ap2=$ap->where('id', $this->uri->segment(6))->get();
        
		$this->form_validation->set_rules('sysname','Имя','required|trim|xss_clean|max_length[30]');			
		$this->form_validation->set_rules('title','Название','required|trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('description','Описание','trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
		if ($this->form_validation->run() === false)
		{
			return false;
		}
        if(empty($essence_id)){
            return false;
        }
        
			$ap2->sysname= $this->input->post('sysname');
			$ap2->title= $this->input->post('title');
			$ap2->description= $this->input->post('description');
			$ap2->status= $this->input->post('status');
			$ap2->essence_id= $essence_id;
		
		
			if ($ap2->save())
			{
				$return = true;
			} else
			{
				Template::set_message('Ошибка: ' . $ap2->error->string, 'error');
				$return = false;
			}
		
		return $return;
        
    }


	public function create_attr() 
	{
		$essence_id=(int)$this->uri->segment(5);
		if ($this->input->post('submit'))
		{
			if ($this->save_attr())
			{
				Template::set_message('Всё нормально', 'success');
				Template::redirect(SITE_AREA .'/analytics/analytic_essences/index/'.$essence_id);
			}
			else 
			{
				//Template::set_message('Ошибка' . $this->package_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', 'Создать новый атрибут');
		Template::set('essence_id', $essence_id);
		Template::set_view('analytics/attr_form');
		Template::render();
	}

  	public function edit_attr() 
	{
		$essence_id=(int)$this->uri->segment(5);
        $id = (int)$this->uri->segment(6);
		
		if (empty($id))
		{
			Template::set_message('Неправильный id)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_essences/index/'.$essence_id);
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_attr())
			{
				Template::set_message('Всё нормально', 'success');
                redirect(SITE_AREA .'/analytics/analytic_essences/index/'.$essence_id);
			}
			else 
			{
				//Template::set_message('Возникла ошибка ' . $this->permission_model->error, 'error');
			}
		}
        $aea=new Analytic_essence_attr();
		
		Template::set('essences_attr', $aea->where('id',$id)->get());
		Template::set('essence_id', $essence_id);
	
		Template::set('toolbar_title','Редактирование атрибута');
		Template::set_view('analytics/attr_form');
		Template::render();		
	}  
    
	public function delete_attr() 
	{	
		$essence_id=(int)$this->uri->segment(5);
		$id = $this->uri->segment(6);
	
		if (!empty($id))
		{	
            $ap=new Analytic_essence_attr();
            $ap2=$ap->where('id',$id)->get();
            if ($ap2->delete())
			{
				Template::set_message('Удаление атрибута прошло успешно.', 'success');
			} else
			{
				Template::set_message('Возникли ошибки при удалении аттрибута: ' . $ap2->error->string, 'error');
			}
		}
		
		redirect(SITE_AREA .'/analytics/analytic_essences/'.$essence_id);
	}
    
    //--------------------------------------------------------------------

      

}

// End Database Settings class