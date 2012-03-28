<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Infoblocks extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('Site.Infoblocks.View');
        Template::set('toolbar_title', 'Формы сайта');
    }

    //--------------------------------------------------------------------


    public function index()
    {
        
        $tables = new Infotable();
        
        if($this->input->post('addnewtable'))
        {
            $tables->name = $this->input->post('newtablename');      
            $tables->user_id = $this->input->post('user_id');  
            if($tables->save())
            Template::set_message('Таблица добавлена','success');
            else
            Template::set_message('Таблица не сохранена','error');            
        }
        
        if($this->input->post('action')=='delete')
        {
            if(count($this->input->post('toaction'))>0)
            {
                foreach($this->input->post('toaction') as $k => $v)
                {
                    $i = new Infotable();   
                    $i->where('id', $k)->get()->delete();
                    //$i->delete();
                }
            }
        }
        
        $tables = new Infotable();    
        Template::set('tables', $tables->get()->all);              
        Template::render();
    }

    //--------------------------------------------------------------------

    public function edit()
    {
        $activetable = $this->uri->segment(5);
        $table = new Infotable();
        $table->where('id', $activetable)->get(); 
        
        if($this->input->post('edittable'))
        {
            $table->name = $this->input->post('newtablename');      
            $table->user_id = $this->input->post('user_id');  
            if($table->save())
            Template::set_message('Название изменено','success'); 
            else
            Template::set_message('Таблица не сохранена','error');            
        }
        
        
        Template::set('activetable', $table); 
        $tables = new Infotable();
        Template::set('tables', $tables->get()->all); 

        Template::render();
    }

    //--------------------------------------------------------------------

}

// End Database Settings class