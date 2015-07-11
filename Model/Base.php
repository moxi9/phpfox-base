<?php

namespace Apps\PHPfox_Base\Model;

class Base extends \Core\Model {
	public function menu() {
		$menus = [
			'Intro' => '/base',
			'Forms' => '/base/forms',
			'Adding a Feed' => '/base/adding-a-feed',
			'Database' => '/base/database',
			'External Controller' => '/base/external-controller',
			'Active User' => '/base/active-user',
			'AJAX Popups' => '/base/popups',
			'Comments & Likes' => '/base/comments-and-likes',
			'Phrases' => '/base/phrasing'
		];

		return $menus;
	}
}