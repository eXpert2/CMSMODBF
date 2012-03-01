<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Генератор отчётов');  

    }

    //--------------------------------------------------------------------


    public function index()
    {
        
        
        
        
        
        $r = new Report();
        $currentrep = new Report();  
        $rnow = $currentrep->where('id', $this->uri->segment(5))->get();

        if($this->input->post('submit'))
        {
            $rnow->sysname = $this->input->post('sysname');
            $rnow->title = $this->input->post('title');
            $success = $rnow->save();
            if($success){
                Template::set('success', @$success);
            }else{
                $error=$rnow->error->string;
                Template::set('error', @$error);
            }
        
        }elseif($this->input->post('delete')){
            $success = $rnow->delete();
            if($success){
                Template::set('success', @$success);
            }else{
                $error=$rnow->error->string;
                Template::set('error', @$error);
            }
            
            
        }


        
        Template::set('allreports', @$r->get()->all);
        Template::set('reporttpl', $rnow);    

        //Template::set('alltpl', $t->get()->all);
        Template::render();
    }
    
     public function edit()
    {
        
        $r = new Report();
        $currentrep = new Report();  
        $rnow = $currentrep->where('id', $this->uri->segment(5))->get();
        
        if($this->input->post('submit'))
        {
        $rnow->sysname = $this->input->post('sysname');
        $rnow->title = $this->input->post('title');
//        $tnow->active = $this->input->post('active');
        $success = $rnow->save();
        //Template::set('success', @$success);
        if($success){
            redirect(SITE_AREA .'/reports/repgenerator/index/'.$rnow->id);
        }else{
            $error=$rnow->error->string;
            Template::set('error', @$error);
            
        }
        
        }

        Template::set('reporttpl', $rnow);    
        //Template::set('alltpl', $t->get()->all);
        //Template::set_view('settings/permission_form');
        
        Template::render();
    }
    
    public function savereport(){
        if(isset($_REQUEST['newReport'])){
            $rep= new Reports();
            $rep->sysname=$_REQUEST['sysname'];
            $rep->title=$_REQUEST['title'];
            if ($rep->save()){
                    echo 'OK';
                }
                else{
                    echo $rep->error->string;

                }

        }
        
    }
    
    
    
    //--------------------------------------------------------------------

      

}

// End Database Settings class