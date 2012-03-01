<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'core_modules/infoblockstables/libraries/basefield.php');

class Testfield extends Basefield {

    var $Testing=true;

    function __construct()
    {
        parent::__construct();
    }

}


// End sidebar class