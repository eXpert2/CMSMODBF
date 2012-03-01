<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Basefield extends Base_Controller {

    var $html;
    var $field;
    var $fieldConfig;
    var $Testing=true;

    function __construct()
    {
        $this->load->config('tablefields');
        $this->tablefields = $this->config->item('tablefields');

        $this->load->config('fldformtypes');
        $this->fldformtypes = $this->config->item('fldformtypes');
        $this->ftprefix = $this->config->item('tableformprefix');
    }

	public function index($field=null, $returnHTML = true)
	{
		if($field==null) return;
		$this->field = $field;
		mb_internal_encoding("utf-8");
		switch($this->field->fieldtype)
		{
			case"varchar":
            $this->field->maxlength = 200;
			break;
			case"text":
            $this->field->maxlength = 5000;
			break;
			case"int":
            $this->field->maxlength = 10;
			break;
			default:
			$this->field->maxlength = 20;
			break;
		}

		$this->fieldConfig = $this->fldformtypes[$this->field->fldformtype];
		$this->html = "";

        if(preg_match('/_titleID/',$this->field->fldformtype))
        return $this->_handleDictionaryField();

        switch($this->field->fldformtype)
        {
        	case"AutoID":
        	$this->_getPrimaryIDField();
        	break;
        	case"text":
        	$this->_getTextField();
        	break;
        	case"numeric":
        	$this->_getDefaultField();
        	break;
        	case"password":
        	$this->_getPasswordField();
        	break;
        	case"date":
        	$this->_getDateField();
        	break;
        	case"textarea":
        	$this->_getTextAreaField();
        	break;
        	case"email":
        	$this->_getDefaultField();
        	break;
        	case"hidden":
        	$this->_getDefaultField();
        	break;
        	case"wisiwig":
        	$this->_getSIMPLEWISIWIGField();
        	break;
        	case"uploadify_doc":
        	$this->_getUploadDocField();
        	break;
        	case"uploadify_image":
        	$this->_getUploadImageField();
        	break;
        	default:
        	$this->_getDefaultField();
        	break;
        }


		$this->_echoHTML();
	}

	function _getPrimaryIDField()
	{
         if($this->field->recordID>0)  $this->nextID = $this->field->recordID;
         else
         $this->nextID = $this->_get_next_id($this->db->dbprefix.$this->field->tablename);
         $this->html = "<input name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."' type='text'  maxlength='".$this->field->maxlength."'  readonly='readonly' value='".$this->nextID."'>";
	}

	function _getDefaultField()
	{
         $this->html = "<input  name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'  type='text'  maxlength='".$this->field->maxlength."'  value='".$this->field->fieldvalue."'>";
	}
    function _getPasswordField()
	{
         $this->html = "<input  name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'  type='password' value='".$this->field->fieldvalue."'>";
	}

	function _getTextField()
	{
         $this->html = "<input  name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'  type='text'  maxlength='".$this->field->maxlength."'  value='".$this->field->fieldvalue."'>";
	}

	function _getTextAreaField()
	{
         $this->html = "<textarea name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'   maxlength='".$this->field->maxlength."' >".$this->field->fieldvalue."</textarea>";
	}

	function _getDateField()
	{
		$this->field->fieldvalue = substr($this->field->fieldvalue,0,10);
		$this->html  = "<input name='".$this->field->fieldname."' readonly='readonly' id='Id_".$this->field->fieldname."' type='text'  maxlength='".$this->field->maxlength."'  value='".$this->field->fieldvalue."'>";
		$this->html .= "
		<link href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\"/>
		<script src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js\"></script>
		<script>
		  head.ready(function(){
		    jQuery('#Id_{$this->field->fieldname}').datepicker({ dateFormat: 'yy-mm-dd' });
		  });
		  </script>
		";
	}


	function _getFULLWISIWIGField()
	{
         $scripturl = site_url()."assets/js/tinymce/tiny_mce.js";
         $this->html = "
         <script src=\"$scripturl\"></script>
         <script language=\"javascript\">
         tinyMCE.init({
				// General options
				mode : 'specific_textareas',
        		editor_selector : '".$this->field->fieldname."_mceEditor',
				theme : 'advanced',
				plugins : \"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave\",
				// Theme options
				theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect',
				theme_advanced_buttons2 : 'pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor',
				theme_advanced_buttons3 : '',
				theme_advanced_buttons4 : '',
				theme_advanced_toolbar_location : 'top',
				theme_advanced_toolbar_align : 'left',
				theme_advanced_statusbar_location : 'bottom',
				theme_advanced_resizing : true,

			});
         </script>

         <textarea  name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'  class='".$this->field->fieldname."_mceEditor' style='width:100%;height:400px;'>".$this->field->fieldvalue."</textarea>
         ";
	}

	function _getSIMPLEWISIWIGField()
	{
         $scripturl = site_url()."assets/js/tinymce/tiny_mce.js";
         $this->html = "
         <script src=\"$scripturl\"></script>
         <script language=\"javascript\">
         tinyMCE.init({
				// General options
				mode : 'specific_textareas',
        		editor_selector : '".$this->field->fieldname."_mceEditor',
				theme : 'advanced',
				plugins : \"autolink,lists,advlink,iespell,inlinepopups,media,searchreplace,directionality,visualchars,nonbreaking,xhtmlxtras,wordcount,advlist,autosave\",
				// Theme options
				theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,undo,redo,|,link,unlink,cleanup,code',
				theme_advanced_buttons2 : '',
				theme_advanced_buttons3 : '',
				theme_advanced_buttons4 : '',
				theme_advanced_toolbar_location : 'top',
				theme_advanced_toolbar_align : 'left',
				theme_advanced_statusbar_location : 'bottom',
				theme_advanced_resizing : true,

			});
         </script>

         <textarea  name='".$this->field->fieldname."' id='Id_".$this->field->fieldname."'  class='".$this->field->fieldname."_mceEditor' style='width:100%;height:400px;'>".$this->field->fieldvalue."</textarea>
         ";
	}

    function _getUploadDocField()
	{
	   $siteUrl = site_url();
	   $scripturl = site_url()."assets/js/uploadify";
	   $allowedstr = implode(',',$this->fieldConfig['allowed']);
	   $SID = session_id();
	   if($this->Testing==true)
	   {
	   	$uploadscript = $scripturl.'/uploadifydebug.php';
	   } else {
	   	$uploadscript = $siteUrl.'uploadify/uploadify';
	   	//$uploadscript = $scripturl.'/uploadify.php';
	   }


	    Assets::add_js( array(
		        $scripturl."/swfobject.js",
		        $scripturl."/jquery.uploadify.v2.1.4.min.js"
		    ),
		    'external',
		    true);

	   $recfile = new Recfile();
	   $recfile->get_where(array(
						'tableID' => $this->field->tableID,
						'fieldID' => $this->field->id,
						'recordID' => $this->field->recordID
						), 1, 0);

		//echo " {$this->field->tableID} {$this->field->id} {$this->field->recordID} ";
		//exit;

	   if($recfile->result_count()>0)
	   {
	   		$fileshtml = "
			<a class=\"{$this->field->fieldname}_uploadify_files\" id=\"file_{$recfile->id}\" href=\"{$recfile->path}\" target='_blank'>{$recfile->path}</a>
	   		";
	   }

	   $this->html = <<<END
					<link href="$scripturl/uploadify.css" type="text/css" rel="stylesheet" />
					<style>
					div.{$this->field->fieldname}_uploadify_files {width:350px;}
					img.{$this->field->fieldname}_uploadify_images {border:1px solid #999; margin:2px; float:left; }
					</style>
					<input id="{$this->field->fieldname}_uploadify" name="{$this->field->fieldname}" type="file" /> <br />
					<input type="button" value="Загрузить файл" onclick="jQuery('#{$this->field->fieldname}_uploadify').uploadifyUpload();"><br />
					<div class="{$this->field->fieldname}_uploadify_files">
                        $fileshtml
					</div>
					<script type="text/javascript">
					head.ready(function(){
					  jQuery('#{$this->field->fieldname}_uploadify').uploadify({
					    'uploader'  : '$scripturl/uploadify.swf',
					    'script'    : '{$uploadscript}',
					    'cancelImg' : '$scripturl/cancel.png',
					    'folder'    : '/files/uploads/docs',
					    'multi'		: false,
					    'queueSizeLimit' : 1,
					    'auto'      : false,
					    'scriptData': {'PHPSESSID':'{$SID}',fieldID:'{$this->field->id}','allowed':'$allowedstr',recordID:jQuery('#Id_id').attr('value'),tableID:jQuery('#tableID').attr('value')},
					    'onError':    function(event,ID,fileObj,errorObj) {
					    	alert(errorObj.type + ' Error: ' + errorObj.info);
					    },
					    'onComplete': function(event, ID, fileObj, response, data) {

										//alert(response);
										if(response==0)
										{
											alert('Не правильный формат файла, загрузите документ.');
										} else {
										jQuery('.{$this->field->fieldname}_uploadify_files').html('<a id="file_'+ID+'" href="'+response+'" target="_blank">'+'Загружен: '+(response)+'</a>');
										jQuery('#file_'+ID).fadeIn('slow');
										}
									  }
					  });

					});
					</script>
END;
	}

	function _getUploadImageField()
	{
	   $siteUrl = site_url();
	   $scripturl = site_url()."assets/js/uploadify";
	   $allowedstr = implode(',',$this->fieldConfig['allowed']);
	   $SID = session_id();
      if($this->Testing==true)
	   {
	   	$uploadscript = $scripturl.'/uploadifydebug.php';
	   } else {
	   	$uploadscript = $siteUrl.'uploadify/uploadify';
	   	//$uploadscript = $scripturl.'/uploadify.php';
	   }
	    Assets::add_js( array(
		        $scripturl."/swfobject.js",
		        $scripturl."/jquery.uploadify.v2.1.4.min.js"
		    ),
		    'external',
		    true);

	   $recfile = new Recfile();
	   $recfile->get_where(array(
						'tableID' => $this->field->tableID,
						'fieldID' => $this->field->id,
						'recordID' => $this->field->recordID
						), 1, 0);
	   //$recfile->get();

	   if($recfile->result_count()>0)
	   {
	   		$imageshtml = "
			<img class=\"{$this->field->fieldname}_uploadify_images\" id=\"img_{$recfile->id}\"  src=\"{$recfile->path}\" width=\"150\">
	   		";
	   }

	   $this->html = <<<END
					<link href="$scripturl/uploadify.css" type="text/css" rel="stylesheet" />
					<style>
					div.{$this->field->fieldname}_uploadify_files {width:350px;}
					img.{$this->field->fieldname}_uploadify_images {border:1px solid #999; margin:2px; float:left; }
					</style>
					<input id="{$this->field->fieldname}_uploadify" name="{$this->field->fieldname}" type="file" /> <br />
					<input type="button" value="Загрузить файл" onclick="jQuery('#{$this->field->fieldname}_uploadify').uploadifyUpload();"><br />
					<div class="{$this->field->fieldname}_uploadify_files">
                        $imageshtml
					</div>
					<script type="text/javascript">
					head.ready(function(){
					  jQuery('#{$this->field->fieldname}_uploadify').uploadify({
					    'uploader'  : '$scripturl/uploadify.swf',
					    'script'    : '{$uploadscript}',
					    'cancelImg' : '$scripturl/cancel.png',
					    'folder'    : '/files/uploads/images',
					    'multi'		: false,
					    'queueSizeLimit' : 1,
					    'auto'      : false,
					    'scriptData': {'PHPSESSID':'{$SID}',fieldID:'{$this->field->id}','allowed':'$allowedstr',recordID:jQuery('#Id_id').attr('value'),tableID:jQuery('#tableID').attr('value')},
					    'onError':    function(event,ID,fileObj,errorObj) {
					    	alert(errorObj.type + ' Error: ' + errorObj.info);
					    },
					    'onComplete': function(event, ID, fileObj, response, data) {
					    				//alert(fileObj.filePath);
					    				//alert(response);
										jQuery('.{$this->field->fieldname}_uploadify_files').html('<img class="{$this->field->fieldname}_uploadify_images" id="img_'+ID+'" style="display:none;" src="'+response+'" width="150">');
										jQuery('#img_'+ID).fadeIn('slow');
									  }
					  });

					});
					</script>
END;
	}


    function _handleDictionaryField()
    {
         $fieldtype = $this->field->fldformtype;
         $table = $this->db->dbprefix."formdic".array_shift(explode('_',$fieldtype));
         $query = $this->db->query("select * from $table order by title ASC");

         if ($query->num_rows() > 0)
		 {
		    $this->html .= "<select name='{$this->field->fieldname}' id='{$this->field->fieldname}'>";
		    foreach ($query->result() as $record)
		    {
		       if($this->field->fieldvalue==$record->id) $selected = "selected='selected'"; else $selected = "";
		       $this->html .= "<option value='{$record->id}' $selected>{$record->title}</option>";
		    }
		    $this->html .= "</select>";
		 }

         $this->_echoHTML();
    }

	function _echoHTML()
	{
        echo $this->html;
	}

	 function _get_next_id($table) {
	    $result = mysql_query("SHOW TABLE STATUS LIKE '$table'");
	    $rows = mysql_fetch_assoc($result);
	    return $rows['Auto_increment'];
	 }


	//--------------------------------------------------------------------

}
