<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core_modules/infoblockstables/libraries/basefield.php');

class Field extends Basefield {

    var $Testing=false;

    function __construct()
    {
        parent::__construct();
    }

}

// End class