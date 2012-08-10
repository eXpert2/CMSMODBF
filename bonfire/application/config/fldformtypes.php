<?php


$config['fldformtypes'] = array(
                         'text' => array(
                                                  'title'=>'Текстовое поле',
                                                  'type' => 'textfield',
                                                  'constraint' => 255,
                                                  'vtype'=>'text'
                                           ),
                         'numeric' => array(
                                                  'title'=>'Цифровое поле',
                                                  'type' => 'numberfield',
                                                  'constraint' => 20,
                                                  'vtype'=>'number'
                                           ),
                         'password' => array(
                                                  'title'=>'Поле для пароля',
                                                  'type' => 'textfield',
                                                  'constraint' => '50',
                                                  'vtype'=>'password',
                                                  'inputType'=>'password',
                                                  'encripting'=>'md5'
                                           ),
                         'date' => array(
                                                  'title'=>'Поле для даты',
                                                  'type' =>'datefield',
                                                  'constraint' => '30',
                                                  'vtype'=>'date'
                                           ),
                         'textarea' => array(
                                                  'title'=>'Текстовый блок TEXTAREA',
                                                  'type' => 'textareafield',
                                                  'constraint' => '500',
                                                  'vtype'=>'text'
                                           ),
                         'email' => array(
                                                  'title'=>'Поле для email',
                                                  'type' => 'textfield',
                                                  'constraint' => '100',
                                                  'vtype'=>'email'
                                           ),
                         'hidden' => array(
                                                  'title'=>'Скрытое поле',
                                                  'type' => 'hiddenfield',
                                                  'constraint' => '100',
                                                  'vtype'=>'hidden'
                                           ),
                         'wisiwig' => array(
                                                  'title'=>'Текстовый блок WISIWIG',
                                                  'type' => 'htmleditor',
                                                  'constraint' => '2000',
                                                  'vtype'=>'html'
                                            ),
                         'uploadify_doc' => array(
                                                  'title'=>'Загрузка файла UPLOADIFY (doc)',
                                                  'name'=>'Flash Uploader',
                                                  'type' => 'uploadify',
                                                  'constraint' => '255',
                                                  'vtype'=>'text',
                                                  'allowed'=>array('txt','rtf','docx','xlsx','pptx','pdf','doc','xls','ppt','odt','log')
                                            ),
                         'uploadify_image' => array(
                                                  'title'=>'Загрузка картинки UPLOADIFY (image)',
                                                  'name'=>'Flash Uploader',
                                                  'type' => 'uploadify',
                                                  'constraint' => '255',
                                                  'vtype'=>'text',
                                                  'allowed'=>array('jpeg','jpg','png','gif')
                                            ),
                         'uploadify_imagelist' => array(
                                                  'title'=>'Загрузка картинок UPLOADIFY IMAGELIST',
                                                  'name'=>'Flash Uploader',
                                                  'type' => 'uploadify',
                                                  'constraint' => '255',
                                                  'vtype'=>'text',
                                                  'allowed'=>array('jpeg','jpg','png','gif')
                                            )

                 );
