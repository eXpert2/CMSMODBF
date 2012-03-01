<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Infoblocks extends Admin_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('Site.Infoblocks.View');
        Template::set('toolbar_title', 'Справочники форм');
    }

    //--------------------------------------------------------------------


    public function index()
    {

        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $ftprefix = $this->config->item('tableformprefix');




        if($this->input->post('addnewtable'))
        {
            $table_name = $ftprefix.$this->input->post('newtablename');
            if(!preg_match("/^([a-z0-9])+$/i",$this->input->post('newtablename')))
            { // не будем добавлять не корректные таблицы в БД
            	$errors[] = 'Название таблицы может содержать только EN формат';
            }

            //echo "<pre>";
	        //print_r($this->input->post('fields')); // name
	        //print_r($this->input->post('fieldtypes')); // type
	        //print_r($this->input->post('fieldtitles')); // formtype

	        if($this->db->table_exists($table_name))
	        {
               $errors[] = 'Таблица '.$table_name.' уже существует.';

	        }
	        if(is_array($this->input->post('fields')) && count($errors)<1)
	        {

	        	$tableflds = $this->input->post('fields');
	        	$tfldformtypes = $this->input->post('fldformtypes');
	        	$tfldformtitles = $this->input->post('fieldtitles');
	        	foreach($this->input->post('fieldtypes') as $k =>$fld)
	        	{
                   if(!preg_match("/^([a-z0-9])+$/i",$tableflds[$k]))
		            { // не будем добавлять не корректные поля в БД
		            	$errors[] = 'Название поля может содержать только латынские буквы';
		            }  else {
	                   $flds[$tableflds[$k]] = $this->tablefields[$fld];
	                   $query = $this->db->get_where($this->db->dbprefix.'extforms', array('tablename' => $table_name,'fieldname'=>$tableflds[$k]));
					   if ($query->num_rows() > 0)
					   {
	                       $errors[] = 'Поле '.$tableflds[$k].' уже существует.';
					   } else {
					   	$this->db->query("insert into ".$this->db->dbprefix."extforms set tablename=?, fieldname=?, fieldtype=?, fldformtype=?, fieldtitle=?",array($table_name,$tableflds[$k],$fld,$tfldformtypes[$k],$tfldformtitles[$k]));
					   }
				   }
	        	}
	        }

            if(count($errors)<=0)
            {

			// Virt tableNames
			$T = new Extformtable();
			$T->name     = $table_name;
			$T->noprefix = $this->input->post('newtablename');
			$T->fullname = $this->db->dbprefix.$table_name;
			$T->title = $this->input->post('newtabletitle');
			$T->save();


			$this->load->dbforge();
            $this->dbforge->add_field($flds);
            $this->dbforge->add_key('id', TRUE);

            if ($this->db->table_exists($table_name))
			{
			    Template::set_message('Таблица не добавлена, таблица с таким именем уже существует?','error');
			} elseif($this->dbforge->create_table($table_name))
		            {
			            Template::set_message('Таблица добавлена','success');
		            }

	        } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }
        }

        if($this->input->post('action')=='delete')
        {
            if(count($this->input->post('toaction'))>0)
            {
                foreach($this->input->post('toaction') as $tblname => $v)
                {
                    $tblname = preg_replace("/".$this->db->dbprefix."/",'',$tblname);
                    $this->db->query("delete from ".$this->db->dbprefix."extforms where tablename=?",array($tblname));
                    $this->load->dbforge();
                    $this->dbforge->drop_table($tblname);
                    $T = new Extformtable();
			        $T->where('name',$tblname)->get();
			        $T->delete();
                }
            }
        }

        $ftables = array();
        $tbls = $this->db->list_tables();
		foreach ($tbls as $k=>$tbl)
		{
		            if(preg_match("/$ftprefix/",$tbl))
		            {
		   $ftables[] = $tbl;
		   }
		}

        Template::set('T',@$T);
        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
        Template::set('formtables', $ftables);
        Template::render();
    }

    //--------------------------------------------------------------------

    public function edit()
    {
        $errors = array();
        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $ftprefix = $this->config->item('tableformprefix');

        $activetable = $table_name = $this->uri->segment(5);
        if(!$this->db->table_exists($table_name))
	    {
           $errors[] = "Таблица не существует.";
           show_error(implode('<br>',$errors));
	    }


        $oldtablenamenoprefix = $tblnamenoprefix = preg_replace("/".$this->db->dbprefix."/",'',$activetable);

        // Virt tableNames
        $T = new Extformtable();
        $T->where('fullname',$activetable)->get();

        if($this->input->post('edittable') && count($errors)<=0)
        {

            if(!preg_match("/^([a-z0-9])+$/i",$this->input->post('newtablename')))
            { // не будем добавлять не корректные таблицы в БД
            	$errors[] = 'Название таблицы может содержать только EN формат';
            }
 			$newtblnamenoprefix = $ftprefix.$this->input->post('newtablename');
 			$newtblname = $this->db->dbprefix.$newtblnamenoprefix;
	        if($this->db->table_exists($table_name))
	        {
             if($table_name!=$newtblname){
             $this->db->query("RENAME TABLE `$table_name` TO `$newtblname`");

             }
             $activetable = $table_name = $newtblname;
	        }
            // еще раз синхронизируем название таблицы после обновления
            $tblnamenoprefix = preg_replace("/".$this->db->dbprefix."/",'',$activetable);
            $this->db->query("update ".$this->db->dbprefix."extforms set `tablename`=? where `tablename`=?",array($tblnamenoprefix,$oldtablenamenoprefix));
            // Virt tableName update
			$T->name     = $tblnamenoprefix;
			$T->noprefix = $this->input->post('newtablename');
			$T->fullname = $activetable;
			$T->title = $this->input->post('newtabletitle');
			$T->save();

	        if(is_array($this->input->post('fields')) && count($errors)<1)
	        {
	        	$tableflds = $this->input->post('fields');
	        	$tfldformtypes = $this->input->post('fldformtypes');
	        	$tfldformtitles = $this->input->post('fieldtitles');
	        	foreach($this->input->post('fieldtypes') as $k =>$fld)
	        	{
                   if(!preg_match("/^([a-z0-9])+$/i",$tableflds[$k]))
		            { // не будем добавлять не корректные поля в БД
		            	$errors[] = 'Название поля может содержать только латынские буквы';
		            }  else {
	                   $query = $this->db->get_where($this->db->dbprefix.'extforms', array('tablename' => $tblnamenoprefix,'fieldname'=>$tableflds[$k],'id'=>$k));
					   if ($query->num_rows() > 0)
					   {
	                       $this->db->query("update ".$this->db->dbprefix."extforms set tablename=?, fieldname=?, fieldtype=?, fldformtype=?, fieldtitle=? where id=?",array($tblnamenoprefix,$tableflds[$k],strtolower($fld),$tfldformtypes[$k],$tfldformtitles[$k],$k));
					   } else {
					   	$flds[$tableflds[$k]] = $this->tablefields[$fld];
                        $this->load->dbforge();
						$this->dbforge->add_column($tblnamenoprefix, $flds);
					   	$this->db->query("insert into ".$this->db->dbprefix."extforms set tablename=?, fieldname=?, fieldtype=?, fldformtype=?, fieldtitle=?",array($tblnamenoprefix,$tableflds[$k],strtolower($fld),$tfldformtypes[$k],$tfldformtitles[$k]));
					   }
				   }
	        	}
	        }

			//print_r($flds);
			//exit;

            if(count($errors)<=0)
            {
		        Template::set_message('Таблица сохранена','success');
		        //Template::redirect('/admin/infoblocks/infoblockstables/edit/'.$activetable);
		    } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }
        }

        if($this->input->post('action')=='delete' && count($errors)<=0)
        {
            if(count($this->input->post('toaction'))>0)
            {
                foreach($this->input->post('toaction') as $tblname => $v)
                {
                    $tblname = preg_replace("/".$this->db->dbprefix."/",'',$tblname);
                    $this->db->query("delete from ".$this->db->dbprefix."extforms where tablename=?",array($tblname));
                    $this->load->dbforge();
                    $this->dbforge->drop_table($tblname);
                    $T = new Extformtable();
			        $T->where('name',$tblname)->get();
			        $T->delete();
                }
            }
        }

        $ftables = array();
        $tbls = $this->db->list_tables();
		foreach ($tbls as $k=>$tbl)
		{
		            if(preg_match("/$ftprefix/",$tbl))
		            {
		   $ftables[] = $tbl;
		   }
		}

  		$query = $this->db->get_where($this->db->dbprefix."extforms", array('tablename' => $tblnamenoprefix), 100, 0);
        Template::set('T',$T);
		Template::set('activetable',$query->result());
		Template::set('activetablename',$tblnamenoprefix);
		Template::set('activetablenameforrm',preg_replace("/".$ftprefix."/",'',$tblnamenoprefix));
		Template::set('activetbl',$this->db->dbprefix.$tblnamenoprefix);

        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
        Template::set('formtables', $ftables);
        Template::render();
    }


    public function reclist()
    {
        $errors = array();
        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $ftprefix = $this->config->item('tableformprefix');

        $activetable = $table_name = $this->uri->segment(5);
        $oldtablenamenoprefix = $tblnamenoprefix = preg_replace("/".$this->db->dbprefix."/",'',$activetable);
        if(!$this->db->table_exists($table_name))
	    {
           $errors[] = "Таблица не существует.";
           show_error(implode('<br>',$errors));
	    }
        /*
		echo count($errors);
		echo "<pre>";
		print_r($errors);
		exit;
		*/
        // Virt tableNames
        $T = new Extformtable();
        $T->where('fullname',$activetable)->get();

        if($this->input->post('submitrecord') && count($errors)<=0)
        {

            $title = $this->input->post('newrecord');
            if(empty($title) || trim($title)=='')
            {
            	$errors[] = "Введите значение для поля Title";
            } else {
            	$this->db->query("insert into $activetable set title=? ", array($title));
            }

            if(count($errors)<=0)
            {
		        Template::set_message('Таблица сохранена','success');
		    } else {
	        	Template::set_message(implode('<br>',$errors),'error');
	        }
        }


        if($this->input->post('action')=='delete' && count($errors)<=0)
        {
            if(count($this->input->post('dodelete'))>0)
            {
                foreach($this->input->post('dodelete') as $id => $v)
                {
                  $this->db->query("delete from $activetable where id=?", array($id));
                }
            }
        }

        if($this->input->post('action')=='savelist' && count($errors)<=0)
        {
           if(count($this->input->post('recname'))>0)
            {
                foreach($this->input->post('recname') as $id => $title)
                {
                   $this->db->query("update $activetable set title=? where id=?", array($title,$id));
                }
            }
        }

        if(count($errors)<=0)
        {
        $query = $this->db->query("select * from $activetable order by `id` ASC");
        Template::set('recordlist',$query->result());

        //$query = $this->db->query("select MAX(id) as maxid from $activetable");
        Template::set('maxid',$this->_get_next_id($activetable));
        }


        $ftables = array();
        $tbls = $this->db->list_tables();
		foreach ($tbls as $k=>$tbl)
		{
           if(preg_match("/$ftprefix/",$tbl))
           {
		   $ftables[] = $tbl;
		   }
		}

  		$query = $this->db->get_where($this->db->dbprefix."extforms", array('tablename' => $tblnamenoprefix), 100, 0);

        Template::set('T',$T);
		Template::set('activetable',$query->result());
		Template::set('activetablename',$tblnamenoprefix);
		Template::set('activetablenameforrm',preg_replace("/".$ftprefix."/",'',$tblnamenoprefix));
		Template::set('activetbl',$this->db->dbprefix.$tblnamenoprefix);

        Template::set('tablefields', $this->tablefields);
        Template::set('fldformtypes', $this->fldformtypes);
        Template::set('formtables', $ftables);
        Template::render();
    }

    function deletecolumn()
    {
        $activetableID = $table_name = $this->uri->segment(5);
  		$query = $this->db->get_where($this->db->dbprefix."extforms", array('id'=>$activetableID), 1, 0);


		$this->load->dbforge();
		$activetable = $query->first_row();
		if($this->dbforge->drop_column($activetable->tablename, $activetable->fieldname)){
		$this->db->query("delete from ".$this->db->dbprefix."extforms where id=?", array($activetableID));
		}
    	 Template::redirect(SITE_AREA .'/infoblocks/infoblocksdics/edit/'.$this->db->dbprefix.$activetable->tablename);
    }

    function _get_next_id($table) {
    $result = mysql_query("SHOW TABLE STATUS LIKE '$table'");
    $rows = mysql_fetch_assoc($result);
    return $rows['Auto_increment'];
    }

    //--------------------------------------------------------------------

}

// End Database Settings class