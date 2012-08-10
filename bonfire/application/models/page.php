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
class Page extends DataMapper {

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 3, 'max_length' => 50)
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 3, 'max_length' => 100)
        )

    );

    /**
     * Constructor
     *
     * Initialize DataMapper.
     */
    function Page()
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