<?php
class Errors extends CI_Controller {    
    function __construct() {
        parent::__construct();
    }

    function error_500() {        
        $this->load->view('errors/500_admin');      
    }
}
?>