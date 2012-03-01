<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('Site.Infoblocks.View');
        Template::set('toolbar_title', 'Источники данных');

        $this->load->config('tablefields');
        $this->load->config('fldformtypes');

        $this->tablefields = $this->config->item('tablefields');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $this->ftprefix = $this->config->item('tableformprefix');

        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
    }

    //--------------------------------------------------------------------


    public function index()
    {
        $tableID = $this->uri->segment(5);

        if($this->input->post('addnewtable'))
        {
            if(count($errors)<=0)
            {


	        } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }
        }


        if($tableID>0)
        {
            $table = new Extformtable();
            $table->where('id',$tableID)->get();
            $ofset = (int)$this->uri->segment(6);
            $count = 15;
            $sql = "select * from `{$table->fullname}` order by `id`  ASC";
            $allcount = $this->db->query($sql); // $allcount->num_rows();
            $records = $this->db->query("$sql LIMIT $ofset,$count ");
            Template::set('Records',$records->result());

            $this->load->library('pagination');

			$config['base_url'] = site_url().SITE_AREA."/content/datasources/index/$tableID/";
			$config['total_rows'] = $allcount->num_rows();
			$config['uri_segment'] = 6;
			$config['num_links'] = 10;
			$config['first_link'] = 'Первая';
			$config['last_link'] = 'Последняя';
			$config['next_link'] = '&raquo;';
			$config['prev_link'] = '&laquo;';
			$config['per_page'] = $count;

			$this->pagination->initialize($config);

			Template::set('PagerLinks',$this->pagination->create_links());

        }


        // Virt tableNames
		$T = new Extformtable();

        Template::set('tableID',$tableID);
        Template::set('T',$T->like('name', "%formtable%")->get());
        Template::set('toolbar_title', 'Источник данных > '.$table->title);
        Template::render();
    }

    //--------------------------------------------------------------------

    public function add()
    {
        $errors = array();
        $tableID = $this->uri->segment(5);

        if($tableID>0)
        {
            $table = new Extformtable();
            $table->where('id',$tableID)->get();

            if(!$this->db->table_exists($table->name))
		    {
	           $errors[] = "Таблица не существует.";
	           show_error(implode('<br>',$errors));
		    }

		     $TableFields = $this->db->query("select * from ".$this->db->dbprefix."extforms where tablename=? order by ID ASC", array($table->name));

			 Template::set('TableFields',$TableFields->result());

            /* if FORM SUBMIT */
            if($this->input->post('addrecord'))
            {
                $sql = $flds = array();
                foreach($TableFields->result() as $fld)
                {
                	if($fld->fieldname=='id') continue;
                	$sql[] = " `{$fld->fieldname}`=? ";
                	if($fld->fieldtype=='varchar')
                	{
                		$flds[] = mb_substr($this->input->post($fld->fieldname),0,250); // режем некорректные поля
                	}  else
                	$flds[] = $this->input->post($fld->fieldname);
                }

                $this->db->query("insert into $table->fullname set ".implode(',',$sql), $flds);
                header("location: /admin/content/datasources/index/$tableID");
            }
            /* if FORM SUBMIT */




            $records = $this->db->query("select * from `{$table->fullname}` order by `id`  ASC ");
            Template::set('Records',$records->result());
        }




            if(count($errors)<=0)
            {
		        //Template::set_message('Таблица сохранена','success');
		        //Template::redirect('/admin/infoblocks/infoblockstables/edit/'.$activetable);
		    } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }


        if($this->input->post('action')=='delete' && count($errors)<=0)
        {
            if(count($this->input->post('toaction'))>0)
            {
                foreach($this->input->post('toaction') as $tblname => $v)
                {

                }
            }
        }

        // Virt tableNames
		$T = new Extformtable();

        Template::set('tableID',$tableID);
        Template::set('T',$T->like('name', "%formtable%")->get());
        Template::set('toolbar_title', 'Добавить запись > '.$table->title);
        Template::render();
    }


    public function edit()
    {
        $errors = array();
        $tableID = $this->uri->segment(5);
        $recordID = $this->uri->segment(6);

        if($tableID>0 && $recordID>0)
        {
            $table = new Extformtable();
            $table->where('id',$tableID)->get();

            if(!$this->db->table_exists($table->name))
		    {
	           $errors[] = "Таблица не существует.";
	           show_error(implode('<br>',$errors));
		    }

		     $TableFields = $this->db->query("select * from ".$this->db->dbprefix."extforms where tablename=? order by ID ASC", array($table->name));
			 Template::set('TableFields',$TableFields->result());

            /* if FORM SUBMIT */
            if($this->input->post('saverecord'))
            {
                /*
                echo "<pre>";
                print_r($_POST);
                exit;
                */
                $sql = $flds = array();
                foreach($TableFields->result() as $fld)
                {
                	if($fld->fieldname=='id') continue;
                	$sql[] = " `{$fld->fieldname}`=? ";

                	if($fld->fieldtype=='varchar')
                	{
                		$flds[] = mb_substr($this->input->post($fld->fieldname),0,250);
                	}  else
                	$flds[] = $this->input->post($fld->fieldname);
                }
                $flds[] = $recordID; // добавим $recordID в конец для запроса в БД
                $this->db->query("update $table->fullname set ".implode(',',$sql)." where id=? ", $flds);
                header("location: /admin/content/datasources/index/$tableID");
            }
            /* if FORM SUBMIT */




            $record = $this->db->query("select * from `{$table->fullname}` where id=? order by `id`  ASC ",array($recordID));
            Template::set('Record',$record->first_row('array'));



        }




            if(count($errors)<=0)
            {
		        //Template::set_message('Таблица сохранена','success');
		        //Template::redirect('/admin/infoblocks/infoblockstables/edit/'.$activetable);
		    } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }


        if($this->input->post('action')=='delete' && count($errors)<=0)
        {
            if(count($this->input->post('toaction'))>0)
            {
                foreach($this->input->post('toaction') as $tblname => $v)
                {

                }
            }
        }




        // Virt tableNames
		$T = new Extformtable();

        Template::set('tableID',$tableID);
        Template::set('recordID',$recordID);
        Template::set('T',$T->like('name', "%formtable%")->get());
        Template::set('toolbar_title', 'Редактировать запись > '.$table->title);
        Template::render();
    }

    function douploadify()
    {

    }


    function _get_next_id($table) {
		    $result = mysql_query("SHOW TABLE STATUS LIKE '$table'");
		    $rows = mysql_fetch_assoc($result);
		    return $rows['Auto_increment'];
	    }

    //--------------------------------------------------------------------

}

// End Database Settings class