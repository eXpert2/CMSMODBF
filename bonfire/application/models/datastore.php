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
class Datastore extends DataMapper {

    function Datastore()
    {
        parent::DataMapper();
    }

    function getMaxPos($page_id)
    {
        $o = new Datastore();
        $o->where('page_id',$page_id);
		$o->select_max('pos');
		$o->get();
		return $o->pos;
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