<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Управление группами'); 
  	//	Template::set_block('sub_nav', 'analytic_packages/_sub_nav');
 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		//$this->load->model('analytic_package');
		Assets::add_js($this->load->view('analytics/js', null, true), 'inline');

    }


    //--------------------------------------------------------------------
	public function create() 
	{
        $package_id=(int)$this->uri->segment(5);
		if ($this->input->post('submit'))
		{
			if ($this->save_group())
			{
				Template::set_message('Всё нормально', 'success');
				Template::redirect(SITE_AREA .'/analytics/analytic_groups/index/'.$package_id);
			}
			else 
			{
				//Template::set_message('Ошибка' , 'error');
			}
		}
	
		Template::set('toolbar_title', 'Создать новую группу');
		Template::set('package_id', $package_id);
		Template::set_view('analytics/group_form');
		Template::render();
	}

    public function save_group(){
        $package_id=(int)$this->uri->segment(5);
        if(empty($package_id)){
            return false;
        }
        $ag=new Analytic_group();
        $ag2=$ag->where('id', $this->uri->segment(6))->get();
		$this->form_validation->set_rules('sysname','Имя','required|trim|xss_clean|max_length[30]');			
		$this->form_validation->set_rules('title','Название','required|trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('description','Описание','trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
		if ($this->form_validation->run() === false)
		{
			return false;
		}
			$ag2->sysname= $this->input->post('sysname');
			$ag2->title= $this->input->post('title');
			$ag2->description= $this->input->post('description');
			$ag2->status= $this->input->post('status');
			$ag2->package_id= $package_id;
		
		
			if ($ag2->save())
			{
				$return = true;
			} else
			{
				Template::set_message('Возникли ошибки : ' . $ag2->error->string, 'error');
				
                $return = false;
			}
		
		return $return;
        
    }




    public function index()
    {
        $ap=new Analytic_package();
		$package_id = (int)$this->uri->segment(5);
		
		if (!empty($package_id))
		{
            $ag=new Analytic_group();
            Template::set('groups', $ag->where('package_id',$package_id)->get());
            Template::set('package_id', $package_id);
            
		  
          }
		Template::set('records', $ap->get());
		if (!Template::get("toolbar_title"))
		{
			Template::set("toolbar_title", 'Управление группами выборок');
		}
		Template::render();
        
        
             
        }

    public function package(){
        $package_id = (int)$this->uri->segment(5);
		
		if (empty($package_id))
		{
			Template::set_message('Неправильный id пакета)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_groups');
		}
        $ag=new Analytic_group();
        Template::set('groups', $ag->where('package_id',$package_id)->get());
        Template::set('package_id', $package_id);
	
		Template::set('toolbar_title','Просмотр пакета');
		Template::set_view('analytics/package_form.php');
		Template::render();	       
        
    }

    
	public function edit() 
	{
      $package_id = (int)$this->uri->segment(5);
		$id = (int)$this->uri->segment(6);
		
		if (empty($id))
		{
			Template::set_message('Неправильный id)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_groups/index/'.$package_id);
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_group())
			{
				Template::set_message('Всё нормально', 'success');
                redirect(SITE_AREA .'/analytics/analytic_groups/index/'.$package_id);
			}
			else 
			{
				//Template::set_message('Возникла ошибка ' , 'error');
			}
		}
        $ag=new Analytic_group();
		
		Template::set('groups', $ag->where('id',$id)->get());
        Template::set('package_id', $package_id);
	
		Template::set('toolbar_title','Редактирование группы');
		Template::set_view('analytics/group_form');
		Template::render();		
	}
    
	public function delete() 
	{	
        $package_id = (int)$this->uri->segment(5);
		$id = $this->uri->segment(6);
	
		if (!empty($id))
		{	
            $ag=new Analytic_group();
            $ag2=$ag->where('id',$id)->get();
            if ($ag2->delete())
			{
				Template::set_message('Удаление пакета прошло успешно.', 'success');
			} else
			{
				Template::set_message('Возникли ошибки при удалении группы: ' . $ag2->error->string, 'error');
			}
		}
		
		redirect(SITE_AREA .'/analytics/analytic_groups/index/'.$package_id);
	}
    
    
    
    //--------------------------------------------------------------------

      

}

// End Database Settings class