<?php

/**
 * User Class
 *
 * Transforms users table into an object.
 * This is just here for use with the example in the Controllers.
 *
 * @licence     MIT Licence
 * @category    Models
 * @author      Simon Stenhouse
 * @link        http://stensi.com
 */
class Report extends DataMapper {

    //var $has_one = array("reports");

    var $validation = array(
        array(
            'field' => 'sysname',
            'label' => 'sysName',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 5, 'max_length' => 20)
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 5, 'max_length' => 100)
        )        

    );
    function Report()
    {
        parent::DataMapper();
    }


}

?>