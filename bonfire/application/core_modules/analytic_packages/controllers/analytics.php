<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Управление пакетами');  

		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('analytic_package');
		Assets::add_js($this->load->view('analytics/js', null, true), 'inline');

    }


    //--------------------------------------------------------------------
	public function create() 
	{
		if ($this->input->post('submit'))
		{
			if ($this->save_package())
			{
				Template::set_message('Всё нормально', 'success');
				Template::redirect(SITE_AREA .'/analytics/analytic_packages');
			}
			else 
			{
				Template::set_message('Ошибка' . $this->package_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', 'Создать новый пакет');
		Template::set_view('analytics/package_form');
		Template::render();
	}

    public function save_package(){
        $ap=new Analytic_package();
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
				$return = false;
			}
		
		return $return;
        
    }




    public function index()
    {
        $ap=new Analytic_package();
 
		Template::set('records', $ap->get());
		if (!Template::get("toolbar_title"))
		{
			Template::set("toolbar_title", 'Управление пакетами');
		}
		Template::render();
        
        
             
        }



    
	public function edit() 
	{
		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message('Неправильный id)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_packages');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_package())
			{
				Template::set_message('Всё нормально', 'success');
			}
			else 
			{
				Template::set_message('Возникла ошибка ' . $this->permission_model->error, 'error');
			}
		}
        $ap=new Analytic_package();
		
		Template::set('packages', $ap->where('id',$id)->get());
	
		Template::set('toolbar_title','Редактирование пакета');
		Template::set_view('analytics/package_form');
		Template::render();		
	}
    
	public function delete() 
	{	
		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
            $ap=new Analytic_package();
            $ap2=$ap->where('id',$id)->get();
            if ($ap2->delete())
			{
				Template::set_message('Удаление пакета прошло успешно.', 'success');
			} else
			{
				Template::set_message('Возникли ошибки при удалении пакета: ' . $ap2->error->string, 'error');
			}
		}
		
		redirect(SITE_AREA .'/analytics/analytic_packages');
	}
    
    
    
    //--------------------------------------------------------------------

      

}

// End Database Settings class