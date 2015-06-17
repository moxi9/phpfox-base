<?php

namespace Apps\Phpfox_Base\Model;

class Base extends \Core\Model {
	public function menu() {
		$menus = [
			'Intro' => '/base',
			'Forms' => '/base/forms',
			'Database' => '/base/database',
			'External Controller' => '/base/external-controller'
		];

		return $menus;
	}
}