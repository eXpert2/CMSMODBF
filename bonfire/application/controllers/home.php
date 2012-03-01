<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Front_Controller {

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

        //$this->load->database();

        $this->load->library('users/auth');

        if ($this->auth->is_logged_in() === true)
        {
            Template::redirect('/page/index');
        }

        Assets::add_css(base_url() .'assets/js/extjs407/resources/css/ext-all.css','screen');
        Assets::add_css(base_url() .'assets/css/app.css','screen');
        Template::render();
	}

	//--------------------------------------------------------------------
}