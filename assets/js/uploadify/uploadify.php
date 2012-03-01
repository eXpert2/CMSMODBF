<?php

if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFile =  str_replace('//','/',$targetPath) . strtolower($_REQUEST['recordid'].'_'.$_REQUEST['id'].'_'.$_FILES['Filedata']['name']);

			$ext = array_pop(explode('.',$_FILES['Filedata']['name']));
			$allowed  = explode(',',$_REQUEST['allowed']);

			if (in_array($ext,$allowed)) {
				move_uploaded_file($tempFile,$targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
			} else {
				echo 'Invalid file type.';
			}
		}
?>