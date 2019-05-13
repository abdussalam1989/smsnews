<?php

class Page_model extends CI_Model {
    
        function __construct()
        {
            parent::__construct();
        }
        
        function update_list($save,$id)
	{
		$this->db->where('id', $id);
		$upd = $this->db->update(STATICPAGES, $save);
		if($upd)
			return true;
		else
			return false;	
	}
        
}