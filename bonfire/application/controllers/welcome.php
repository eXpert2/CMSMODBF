<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Front_Controller {

	//--------------------------------------------------------------------
	public function index() 
	{	
		if (!class_exists('BF_Model'))
        {
            $this->load->model('users/MY_Model');
        }
        if (!class_exists('User_model'))
        {
            $this->load->model('users/User_model', 'user_model');
        }
        
        $this->load->database();
        
        $this->load->library('users/auth'); 
        $this->auth->restrict('Site.Backoffice.View');  // проверка права пользователя на просмотр страницы бекофиса
        // при ошибке юзер перенаправляется на стр. с формой входа
        
        Template::render();
	}

	//--------------------------------------------------------------------
}