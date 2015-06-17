<?php

namespace Apps\Phpfox_Base\Model;

class User extends \Core\Model {
	public function random() {
		$users = $this->db->select('*')
			->from(':user')
			->order('RAND()')
			->limit(10)
			->all();

		return $users;
	}
}