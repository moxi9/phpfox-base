<?php

// Load our Base Model for easy access
use \Apps\Phpfox_Base\Model\Base;

// Group all our routes
new Core\Route\Group('/base', function() {

	// Load our base Model
	$Base = new Base;

	/**
	 * @route /base/
	 * Index page
	 */
	new Core\Route('/', function(Core\Controller $Controller) use($Base) {

		// Set the pages title, section title, sub-menu and template file
		return $Controller->title('PHPfox App Base')
				->section('PHPfox App Base', '/base')
				->menu($Base->menu())
				->render('index.html');
	});

	/**
	 * @route /base/forms
	 * Info on how to display and handle forms.
	 */
	new Core\Route('/forms', function(Core\Controller $Controller) use($Base) {

		/**
		 * Here we create the validation rules. This is an inline shorthand version.
		 * When running the make() method it does checks to see if a form has been posted. If it has,
		 * then it runs the check to see if all the fields meets its requirements.
		 */
		(new Core\Validator())
			->rule('email_input')->email()->required()
			->rule('text_input')->required()
			->rule('password_input')->required()->min(4)
			->make();

		$formData = '';
		// Check to see if the form has been posted
		if (($val = $Controller->request->get('val'))) {

			// If the form has been posted build a easy message for developers to see
			$formData = '<div class="message"><pre>' . print_r(array_map('htmlspecialchars', $val), true) . '</pre></div>';

			// Check if this is the AJAX form being posted
			if ($Controller->request->isPost()) {
				// If an AJAX form, return jQuery so JavaScript can run it on the client-end
				return j('#post_data')->html($formData);
			}
		}

		// Set the pages title, section title, h1 tag, sub-menu and template file
		return $Controller->section('PHPfox App Base', '/base')
				->h1('Forms', '/base/forms')
				->title('Forms')
				->menu($Base->menu())
				->render('forms.html', [
					'formData' => $formData
				]);
	});

	/**
	 * @route /base/database
	 * Small example of how to connect to a Model and run a function
	 */
	new Core\Route('/database', function(Core\Controller $Controller) use($Base) {

		// Load our User Model, which will be located at: /PF.Site/PHPfox_Base/Model/User.php
		$User = new \Apps\Phpfox_Base\Model\User();

		// Run the random() function provded by the Model
		$randomUsers = $User->random();

		// Set the pages title, section title, h1 tag, sub-menu and template file
		return $Controller->section('PHPfox App Base', '/base')
			->h1('Database', '/base/forms')
			->title('Database')
			->menu($Base->menu())
			->render('database.html', [
				'users' => $randomUsers
			]);
	});

	/**
	 * @route /base/external-controller
	 * In this example we call an external program via our API routine. This can run any flavor of choice.
	 * For this specific example we use the "api.php" file.
	 */
	(new Core\Route('/external-controller'))->url(param('core.path') . 'PF.Site/Apps/PHPfox_Base/api.php');
});