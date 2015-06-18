<?php

namespace Apps\Phpfox_Base\Model;

class Base extends \Core\Model {
	public function menu() {
		$menus = [
			'Intro' => '/base',
			'Forms' => '/base/forms',
			'Database' => '/base/database',
			'External Controller' => '/base/external-controller',
			'Active User' => '/base/active-user',
			'AJAX Popups' => '/base/popups'
		];

		return $menus;
	}
}