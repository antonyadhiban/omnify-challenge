<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Event extends ORM {
    
	public function get_all_events() {
        $sql = 'SELECT * FROM `event` ORDER BY `id` DESC LIMIT  0, 10';
        return $this->_db->query(Database::SELECT, $sql, FALSE)
                         ->as_array();
    }
}