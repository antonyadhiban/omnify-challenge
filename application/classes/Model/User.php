<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_User extends ORM {
    public function get_user_data() {
        $sql = 'SELECT `refresh_token` FROM `user` WHERE `email = ` ';
        return $this->_db->query(Database::SELECT, $sql, FALSE)
                         ->as_array();
    }
}