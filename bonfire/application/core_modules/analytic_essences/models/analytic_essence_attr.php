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
class Analytic_essence_attr extends DataMapper {
                                       
    var $has_one = array("analytic_essences");

    var $validation = array(
        array(
            'field' => 'sysname',
            'label' => 'Name',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 1, 'max_length' => 50)
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 1, 'max_length' => 100)
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => array('required', 'trim',  'min_length' => 3, 'max_length' => 100)
        )        

    );

    /**
     * Constructor
     *
     * Initialize DataMapper.
     */
    function Analytic_essence_attr()
    {
        parent::DataMapper();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Login
     *
     * Authenticates a user for logging in.
     *
     * @access    public
     * @return    bool
     */
    
}

/* End of file page.php */
/* Location: ./application/models/user.php */