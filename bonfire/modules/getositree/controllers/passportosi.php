<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Passportosi extends Base_Controller {

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        //$this->auth->restrict('Site.Infoblocks.View');
        //Template::set('toolbar_title', 'Справочники форм');
    }

    //--------------------------------------------------------------------


    public function index()
    {

        if($this->input->get('node')!='osisrc')
        {
            $node = $this->input->get('node');
        	$osiID = preg_replace('/osisrc\/osi/','',$node);
        	$query = $this->db->query("select * from bf_formtable_osilist where parentID=? order by osiname ASC",array($osiID));
	        foreach($query->result() as $osi)
	        {

                $childquery = $this->db->query("select * from bf_formtable_osilist where parentID=? order by osiname ASC",array($osi->id));
                if ($childquery->num_rows() > 0){
                $folder = 'folder';
                $leaf = 'false';
                } else {
                	$folder = 'file';
	                $leaf = 'true';
                	}

	        	$nodes[] = array(
	                'text' => $osi->osiname,
	                'id'   => 'osisrc/osi'.$osi->id,
	                'cls'  => $folder,
	                'leaf' => $leaf,
	                'pos'  => $osi->id,
	                'osiID' =>$osi->id
	            );

	        }

        } else {

	        $query = $this->db->query("select * from bf_formtable_osilist where parentID=0 order by osiname ASC");

	        foreach($query->result() as $osi)
	        {
	        	$nodes[] = array(
	                'text' => $osi->osiname,
	                'id'   => 'osisrc/osi'.$osi->id,
	                'cls'  => 'folder',
	                'pos'  => $osi->id,
	                'osiID' =>$osi->id
	            );

	        }
        }

        if(count(@$nodes)<=0)
        $nodes = array();

        echo json_encode($nodes);
        exit;
    }

    public function getosiformdata()
    {
        $data = array();
        $osiID = (int)$this->input->post('osiID');
        if($osiID<=0) return;
        $query = $this->db->query("select * from ".$this->db->dbprefix."extformtables where noprefix=?", array("osilist"));
        $ositabledata = $query->first_row();

        $qformfld = $this->db->query("select * from ".$this->db->dbprefix."extforms where tablename=? order by id ASC", array($ositabledata->name));
		$osiformfields = $qformfld->result();

		$vquery = $this->db->query("select * from ".$ositabledata->fullname." where id=?", array($osiID));
		$osivalue = $vquery->first_row();


        //echo json_encode($data);
        //exit;
        Template::set('osiID', $osiID);
        Template::set('osivalue', $osivalue);
        Template::set('ositabledata', $ositabledata);
        Template::set('osiformfields', $osiformfields);
        Template::render();
    }

    public function saveosiformdata()
    {
        if($this->input->post('action')=='saveosipassport')
        {
         $setlist = $errors = array();

         $osiID = (int)$this->input->post('id');
         if($osiID<=0) {
         	$errors[] = "Не корректный идентификатор паспорта ОСИ.\n";
         };
         $query = $this->db->query("select * from ".$this->db->dbprefix."extformtables where noprefix=?", array("osilist"));
         $ositabledata = $query->first_row();
         $qformfld = $this->db->query("select * from ".$this->db->dbprefix."extforms where tablename=? order by id ASC", array($ositabledata->name));
		 $osiformfields = $qformfld->result();
         foreach($osiformfields as $fld)
         {
         	if($fld->fieldname!='id'){
         	$setlist[] = " `".$fld->fieldname."`='".$this->input->post($fld->fieldname)."' ";
         	}
         }

         if(count($setlist)>0 && count($errors)<=0)
         {
         	$this->db->query("update ".$ositabledata->fullname." set ".implode(',',$setlist)." where id=?", array($osiID));
         	echo '
	        {
			    success: true,
			    msg:"Паспорт ОСИ успешно сохранен."
			}';
         }  else {
         	$errors[] = "Проверьте корректность полей.\n";
         	echo '
	        {
			    success: false,
			    msg:"'.implode(',',$errors).'"
			}';
         }

        }


		exit;
    }


    //--------------------------------------------------------------------

}

// End Database Settings class