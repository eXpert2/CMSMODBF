<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('CP.Tpl.View');
        $this->load->helper('config_file');
        Template::set('toolbar_title', 'Управление шаблонами');

        $this->load->config('tpltypes');
        $this->tpltypes = $this->config->item('tpltypes');
        Template::set('tpltypes', $this->tpltypes);

    }

    //--------------------------------------------------------------------


    public function index()
    {

        $t = new Tpl();

        if($this->input->post('submit'))
        {
        $t->name = $this->input->post('name');
        $t->title = $this->input->post('title');
        $t->descr = $this->input->post('descr');
        $t->tpl = $this->input->post('tpl');
        $t->opt = $this->input->post('opt');
        $t->active = $this->input->post('active');
        $success = $t->save();
        Template::set('success', @$success);
        }

        Template::set('alltpl', $t->get()->all);
        Template::render();
    }

     public function edit()
    {

        $t = new Tpl();
        $currenttpl = new Tpl();
        $tnow = $currenttpl->where('id', $this->uri->segment(5))->get();

        if($this->input->post('submit'))
        {
        $tnow->name = $this->input->post('name');
        $tnow->title = $this->input->post('title');
        $tnow->descr = $this->input->post('descr');
        $tnow->tpl = $this->input->post('tpl');
        $tnow->opt = $this->input->post('opt');
        $tnow->active = $this->input->post('active');
        $success = $tnow->save();
        Template::set('success', @$success);
        }

        Template::set('edittpl', $tnow);
        Template::set('alltpl', $t->get()->all);
        Template::render();
    }




    //--------------------------------------------------------------------



}

// End Database Settings class