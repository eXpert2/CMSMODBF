<?php

$config['tableformprefix'] = "formdic";
$config['tablefields'] = array(
                         'idprimautoinc' => array(
                                                  'type' => 'INT',
                                                  'constraint' => 11,
                                                  'unsigned' => TRUE,
                                                  'auto_increment' => TRUE
                                           ),
                         'int' => array(
                                                  'type' => 'INT',
                                                  'constraint' => 11
                                           ),
                         'varchar' => array(
                                                  'type' => 'VARCHAR',
                                                  'constraint' => '255'
                                           ),
                         'date' => array(
                                                  'type' =>'DATETIME'
                                           ),
                         'text' => array(
                                                  'type' => 'TEXT',
                                                  'null' => TRUE
                                           )
                 );
