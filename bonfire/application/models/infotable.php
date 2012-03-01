<?php

class Infotable extends DataMapper {
                                       
    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 3, 'max_length' => 50)
        )
    );

    /**
     * Constructor
     *
     * Initialize DataMapper.
     */
    function Infotable()
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