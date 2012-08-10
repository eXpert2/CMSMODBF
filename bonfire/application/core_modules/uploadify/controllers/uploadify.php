<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Uploadify extends Base_Controller // Authenticated_Controller
{

	function __construct()
	{
		parent::__construct(); // проверка авторизованности юзера!!!
	}
	public function index($context=null)
	{
         //echo "hello";

         $recfile = new Recfile();

         if (!empty($_FILES)) {

			$tempFile = $_FILES['Filedata']['tmp_name'];
			$ext = array_pop(explode('.',$_FILES['Filedata']['name']));
			$allowed  = explode(',',$_REQUEST['allowed']);


			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFName = $this->_str2url(array_shift(explode('.',$_FILES['Filedata']['name']))).'.'.$ext;

			$targetFile =  str_replace('//','/',$targetPath) . strtolower($_REQUEST['recordID'].'_'.$_REQUEST['fieldID'].'_'.$_REQUEST['tableID'].'_'.$_FILES['Filedata']['name']);
            $targetFileToSave = str_replace('//','/',$targetPath) . strtolower($_REQUEST['recordID'].'_'.$_REQUEST['fieldID'].'_'.$_REQUEST['tableID'].'_'.$targetFName);
            //echo $targetFileToSave;
			//exit;

			if (in_array($ext,$allowed)) {

				$recfile = new Recfile();
				$recfile->get_where(array(
						'tableID' => $_REQUEST['tableID'],
						'fieldID' => $_REQUEST['fieldID'],
						'recordID' => $_REQUEST['recordID']
						), 1, 0);
				//$recfile->get();

				if($recfile->result_count()<=0){
                 	$recfile = new Recfile();
				}



				$recfile->tableID = (int)$_REQUEST['tableID'];
				$recfile->fieldID = (int)$_REQUEST['fieldID'];
				$recfile->recordID = (int)$_REQUEST['recordID'];
                $recfile->name = $_FILES['Filedata']['name'];
                $recfile->ext = $ext;
                $recfile->size = $_FILES['Filedata']['size'];
                $recfile->mime = $_FILES['Filedata']['mime'];
                $recfile->path = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFileToSave);
                $recfile->save();

				move_uploaded_file($tempFile,$targetFileToSave);
				//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				$filepath = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFileToSave);

				$data = array(
				file_path => $filepath,
				file_id => $recfile->id
				);
				echo json_encode($data);

				exit;
			} else {
				echo '0';
				exit;
			}
		}



	}

    function deleterecfile()
    {
    	//$this->load->library('auth');
    	//$this->auth->restrict('Site.Infoblocks.View');
    	if(is_numeric($this->input->post('id')))
    	{
    		$recfile = new Recfile();
			$recfile->get_where(array(
					'id' =>$this->input->post('id')
					), 1, 0);
			if(unlink($_SERVER['DOCUMENT_ROOT'].$recfile->path))
			{
				$recfile->delete();
				echo 1;
			} else {
			echo 0;
			}
    	}

    	exit;

    }


    function saverecfiledata()
    {
    	//$this->load->library('auth');
    	//$this->auth->restrict('Site.Infoblocks.View');
    	if(is_numeric($this->input->post('id')))
    	{

    		$recfile = new Recfile();
			$recfile->get_where(array(
					'id' =>$this->input->post('id')
					), 1, 0);
			$recfile->title = $this->input->post('title');
			$recfile->descr = $this->input->post('descr');
			if($recfile->save())
			{
				echo 1;
			} else {
			echo 0;
			}
    	}

    	exit;

    }
	/// do gallery photo uploads
	public function imagelist($context=null)
	{
         //echo "hello";

         $recfile = new Recfile();

         if (!empty($_FILES)) {

			$tempFile = $_FILES['Filedata']['tmp_name'];
			$ext = array_pop(explode('.',$_FILES['Filedata']['name']));
			$allowed  = explode(',',$_REQUEST['allowed']);


			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFName = $this->_str2url(array_shift(explode('.',$_FILES['Filedata']['name']))).'.'.$ext;

			$targetFile =  str_replace('//','/',$targetPath) . strtolower($_REQUEST['recordID'].'_'.$_REQUEST['fieldID'].'_'.$_REQUEST['tableID'].'_'.$_FILES['Filedata']['name']);
            $targetFileToSave = str_replace('//','/',$targetPath) . strtolower($_REQUEST['recordID'].'_'.$_REQUEST['fieldID'].'_'.$_REQUEST['tableID'].'_'.$targetFName);
            //echo $targetFileToSave;
			//exit;

			if (in_array($ext,$allowed)) {

				$recfile = new Recfile();
				$recfile->tableID = (int)$_REQUEST['tableID'];
				$recfile->fieldID = (int)$_REQUEST['fieldID'];
				$recfile->recordID = (int)$_REQUEST['recordID'];

                if($recfile->tableID>0 && $recfile->fieldID>0 && $recfile->recordID>0)
                {
                	$recfile->recordtype = 'extform';
                } elseif($this->input->post('recordtype'))
                {
                	$recfile->recordtype = $this->input->post('recordtype');
                	$recfile->recordID = $this->input->post('record_id');
                }

                $recfile->name = $_FILES['Filedata']['name'];
                $recfile->ext = $ext;
                $recfile->size = $_FILES['Filedata']['size'];
                $recfile->mime = $_FILES['Filedata']['mime'];
                $recfile->path = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFileToSave);
                $recfile->save();

				move_uploaded_file($tempFile,$targetFileToSave);
				//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				$filepath = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFileToSave);

				$data = array(
				file_path => $filepath,
				file_id => $recfile->id
				);
				echo json_encode($data);

				exit;
			} else {
				echo '0';
				exit;
			}
		}



	}


	//--------------------------------------------------------------------

    function _rus2translit($string) {
	    $converter = array(
	        'а' => 'a',   'б' => 'b',   'в' => 'v',
	        'г' => 'g',   'д' => 'd',   'е' => 'e',
	        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	        'и' => 'i',   'й' => 'y',   'к' => 'k',
	        'л' => 'l',   'м' => 'm',   'н' => 'n',
	        'о' => 'o',   'п' => 'p',   'р' => 'r',
	        'с' => 's',   'т' => 't',   'у' => 'u',
	        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
	        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

	        'А' => 'A',   'Б' => 'B',   'В' => 'V',
	        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	        'О' => 'O',   'П' => 'P',   'Р' => 'R',
	        'С' => 'S',   'Т' => 'T',   'У' => 'U',
	        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
	        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	    );
	    return strtr($string, $converter);
	}

	function _str2url($str) {
	    // переводим в транслит
	    $str = $this->_rus2translit($str);
	    // в нижний регистр
	    $str = strtolower($str);
	    // заменям все ненужное нам на "-"
	    $str = preg_replace('~[^-a-z0-9_]+~u', '_', $str);
	    // удаляем начальные и конечные '-'
	    $str = trim($str, "_");
	    return $str;
	}
}

// End sidebar class