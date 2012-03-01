<?php

class Infoparams extends DataMapper {
                                       
    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 3, 'max_length' => 50,'alpha_dash_dot')
        )
    );

    /**
     * Constructor
     *
     * Initialize DataMapper.
     */
    function Infoparams()
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