<?php


$config['fldformtypes'] = array(
                         'text' => array(
                                                  'title'=>'Текстовое поле',
                                                  'type' => 'text',
                                                  'constraint' => 255,
                                                  'vtype'=>'text'
                                           ),
                         'numeric' => array(
                                                  'title'=>'Цифровое поле',
                                                  'type' => 'text',
                                                  'constraint' => 20,
                                                  'vtype'=>'numeric'
                                           ),                                                                 
                         'password' => array(
                                                  'title'=>'Поле для пароля',
                                                  'type' => 'varchar',
                                                  'constraint' => '50',
                                                  'vtype'=>'password',
                                                  'encripting'=>'md5'
                                           ),
                         'date' => array(
                                                  'title'=>'Поле для даты',
                                                  'type' =>'text',
                                                  'constraint' => '30',
                                                  'vtype'=>'date'
                                           ),
                         'textarea' => array(
                                                  'title'=>'Текстовый блок TEXTAREA',
                                                  'type' => 'textarea',
                                                  'constraint' => '500',
                                                  'vtype'=>'text'
                                           ),
                         'email' => array(
                                                  'title'=>'Поле для email',  
                                                  'type' => 'text',
                                                  'constraint' => '100',
                                                  'vtype'=>'email'
                                           ),
                         'hidden' => array(
                                                  'title'=>'Скрытое поле',  
                                                  'type' => 'hidden',
                                                  'constraint' => '100',
                                                  'vtype'=>'hidden'
                                           ),
                         'wisiwig' => array(
                                                  'title'=>'Текстовый блок WISIWIG',  
                                                  'type' => 'wisiwig',
                                                  'constraint' => '2000',
                                                  'vtype'=>'text'
                                            )      
                                            
                 );
