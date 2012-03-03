<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH.'third_party/smarty/Smarty.class.php' );

class MY_Smarty extends Smarty {

	function __construct()
	{
		parent::__construct();

		$this->compile_dir = APPPATH . "tpl/compile";
		$this->template_dir = APPPATH . "tpl/templates";
        $this->php_handling =  parent::PHP_ALLOW;
		$this->compile_check = true;
		$this->debugging = false;
		$this->caching = false;
	    $this->compile_id = "ru";
	    $this->left_delimiter = '{%';
		$this->right_delimiter = '%}';


		$this->assign( 'APPPATH', APPPATH );
		$this->assign( 'BASEPATH', BASEPATH );

		// Assign CodeIgniter object by reference to CI
		if ( method_exists( $this, 'assignByRef') )
		{
			$ci =& get_instance();
			$this->assignByRef("ci", $ci);
		}

		$this->registerResource('db', new Smarty_Resource_Mysql());

		log_message('debug', "Smarty Class Initialized");
	}


	function view($template, $data = array(), $return = FALSE)
	{

		if(preg_match('/\.tpl/',$template))
		{
			$template = preg_replace('/\.tpl/','',$template);
		}

		if(is_array($data) && count($data)>0){
			foreach ($data as $key => $val)
			{
				$this->assign($key, $val);
			}
		}


		$html = $this->fetch('db:'.$template);


		if ($return == FALSE)
		{
			$CI =& get_instance();
			if (method_exists( $CI->output, 'set_output' ))
			{
				$CI->output->set_output( $html );
			}
			else
			{
				$CI->output->final_output = $html;
			}
			return;
		}
		else
		{
			return $html;
		}
	}
}
// END Smarty Class

// ###################################################3


class Smarty_Resource_Mysql extends Smarty_Resource_Custom {

 var $CI;
 public function __construct() {
     $this->CI = & get_instance();
 }

 protected function fetch($name, &$source, &$mtime)
 {

     $query = $this->CI->db->query("SELECT `modified`, `tpl`  FROM `".$this->CI->db->dbprefix."tpls` WHERE `name` =?",array($name));
	 $row = $query->first_row('array');

     //echo  htmlspecialchars_decode($row['tpl']);
     //exit;
     if ($row) {
         $source = htmlspecialchars_decode($row['tpl']);
         $mtime = strtotime($row['modified']);
     } else {
         $source = null;
         $mtime = null;
     }
 }

 protected function fetchTimestamp($name) {


     $query = $this->CI->db->query("SELECT `modified`  FROM `".$this->CI->db->dbprefix."tpls` WHERE `name` =?",array($name));
	 $row = $query->first_row('array');
     $mtime = $row['modified'];

     //echo strtotime($mtime);
	 //exit;
     return strtotime($mtime);
 }

}