<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Управление кубами');  

		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('analytic_cube');
		Assets::add_js($this->load->view('analytics/js', null, true), 'inline');

    }


    //--------------------------------------------------------------------
	public function create() 
	{
		if ($this->input->post('submit'))
		{
			if ($this->save_cube())
			{
				Template::set_message('Всё нормально', 'success');
				Template::redirect(SITE_AREA .'/analytics/analytic_cubes');
			}
			else 
			{
				Template::set_message('Ошибка' . $this->package_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', 'Создать новый пакет');
		Template::set_view('analytics/cube_form');
		Template::render();
	}

    public function save_cube(){
        $ac=new Analytic_cube();
        $ac2=$ac->where('id', $this->uri->segment(5))->get();
		$this->form_validation->set_rules('sysname','Имя','required|trim|xss_clean|max_length[30]');			
		$this->form_validation->set_rules('title','Название','required|trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('description','Описание','trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
		if ($this->form_validation->run() === false)
		{
			return false;
		}
			$ac2->sysname= $this->input->post('sysname');
			$ac2->title= $this->input->post('title');
			$ac2->description= $this->input->post('description');
			$ac2->status= $this->input->post('status');
		
		
			if ($ac2->save())
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
        $ap=new Analytic_cube();
 
		Template::set('records', $ap->get());
		if (!Template::get("toolbar_title"))
		{
			Template::set("toolbar_title", 'Управление кубами');
		}
		Template::render();
        
        
             
        }
    //***********************************************************
    public function saveExis(){
            $id=(int)$this->uri->segment(5);
            $action=$this->input->post('saveexis');
            if(!empty($action)){
                $ce=new Analytic_cube_axis();
    			$ce->sysname= $this->input->post('sysname_new');
    			$ce->type= $this->input->post('type_new');
    			$ce->cube_id= $id;
    			$ce->title= $this->input->post('title_new');
    			$ce->description= $this->input->post('description_new');
    			$ce->status= $this->input->post('status_new');
      	         if ($ce->save())
    			{
    				Template::set_message('Всё нормально)', 'success');
    			} else
    			{
     				Template::set_message('Всё плохо)', 'error');
    			}
            }else{
                $action=$this->input->post('saveexises');
                if(!empty($action)){
                        $axises=$this->input->post('axis');
                        if(!empty($axises)&& is_array($axises)){
                            $ce=new Analytic_cube_axis();
                            foreach($axises as $key =>$val){
                                if(isset($val['delete'])){
                                    $ce->where('id',$key)->get()->delete();
                                }else{
                        			$ce->id= $key;
                        			$ce->sysname= $val['sysname'];
                        			$ce->type= $val['type'];
                        			$ce->cube_id= $id;
                        			$ce->title= $val['title'];
                        			$ce->description= $val['description'];
                        			$ce->status= $val['status'];
                                     if ($ce->save())
                            			{
                            				Template::set_message('Всё нормально)', 'success');
                            			} else
                            			{
                             				Template::set_message('Всё плохо)', 'error');
                            			}
                                }
                                //echo $key.'='. $ce->error->string;
                                //print_r($val);
                            }
                        }
                        
                        
                    }
                
            }
			
			redirect(SITE_AREA .'/analytics/analytic_cubes/edit/'+$id+'/?ghhh');
        
    }
    


    
	public function edit() 
	{
		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message('Неправильный id)', 'error');
			redirect(SITE_AREA .'/analytics/analytic_cubes');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_cube())
			{
				Template::set_message('Всё нормально', 'success');
			}
			else 
			{
				Template::set_message('Возникла ошибка ' . $this->permission_model->error, 'error');
			}
		}
        $ap=new Analytic_cube();
		
		Template::set('packages', $ap->where('id',$id)->get());
        $ce=new Analytic_cube_axis();
		Template::set('subrecords', $ce->where('cube_id',$id)->get());
	
		Template::set('toolbar_title','Редактирование пакета');
		Template::set_view('analytics/cube_form');
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
		
		redirect(SITE_AREA .'/analytics/analytic_cubes');
	}
    
    
    
    //--------------------------------------------------------------------

      

}

// End Database Settings class