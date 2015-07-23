<?php

// Load our Base Model for easy access
use \Apps\PHPfox_Base\Model\Base;

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
	 * @route /base/adding-a-feed
	 * Learn how to add a new feed
	 */
	(new Core\Route('/adding-a-feed', function(Core\Controller $Controller) use($Base) {

		// Check to see if we posted anything
		if ($Controller->request->isPost()) {
			$Feed = new \Api\Feed();

			// Create a new post. Make sure to pass your "type_id", which is your App id
			$feed = $Feed->post([
				'type_id' => 'PHPfox_Base',
				'content' => $Controller->request->get('val')['status']
			]);

			// Use jquery to output the new feed object
			return j('#ajax_output')->html('<div class="message"><pre>' . print_r($feed, true) . '</pre></div>');
		}

		// Set the pages title, section title, h1 tag, sub-menu and template file
		return $Controller->section('PHPfox App Base', '/base')
			->h1('Adding a Feed', '/base/adding-a-feed')
			->title('Adding a Feed')
			->menu($Base->menu())
			->render('adding-a-feed.html', [

			]);
	}))->auth(true);

	/**
	 * @route /base/database
	 * Small example of how to connect to a Model and run a function
	 */
	new Core\Route('/database', function(Core\Controller $Controller) use($Base) {

		// Load our User Model, which will be located at: /PF.Site/PHPfox_Base/Model/User.php
		$User = new \Apps\PHPfox_Base\Model\User();

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
	(new Core\Route('/external-controller'))->url(str_replace('index.php/', '', param('core.path')) . 'PF.Site/Apps/PHPfox_Base/api.php');

	/**
	 * @route /base/active-user
	 * Passing the ->auth(true) makes sure the user is logged in
	 */
	(new Core\Route('/active-user', function(Core\Controller $Controller) use ($Base) {

		// Set the pages title, section title, h1 tag, sub-menu and template file
		return $Controller->section('PHPfox App Base', '/base')
			->h1('Active User', '/base/active-user')
			->title('Active User')
			->menu($Base->menu())
			->render('active-user.html', [
				'name' => $Controller->active->name
			]);
	}))->auth(true);

	/**
	 * @route /base/popups
	 * Link to create a popup
	 */
	new Core\Route('/popups', function(Core\Controller $Controller) use ($Base) {

		return $Controller->title('Popups')
			->section('PHPfox App Base', '/base')
			->h1('AJAX Popups', '/base/popups')
			->menu($Base->menu())->render('popup.html');
	});

	/**
	 * @route /base/popup-output
	 * Popup output
	 */
	new Core\Route('/popup-output', function(Core\Controller $Controller) use ($Base) {

		return $Controller->h1('Hello!', '/base/popup-output')
			->menu($Base->menu())
			->render('popup-output.html');
	});

	/**
	 * @route /base/comments-and-likes
	 * In this example we look into adding Comments & Likes to your items
	 */
	new Core\Route('/comments-and-likes', function(Core\Controller $Controller) use ($Base) {

		// Load the needed classes
		$ApiFeed = new \Api\Feed();
		$Cache = new \Core\Cache();

		// Check if we cached a feed ID# earlier
		$feedId = $Cache->get('test_feed_id');

		if (!$feedId) {
			// Create a new post
			$feed = $ApiFeed->post([
				'type_id' => 'PHPfox_Base',
				'content' => 'Hello! I am a post.'
			]);

			// Add post to cache so we don't have to create a new post every time
			$Cache->set('test_feed_id', $feed->id);
			$feedId = $feed->id;
		}

		/**
		 * Get a feed. When you get a feed it automatically loads the Comment & Like block routine.
		 * You just need to output it in the HTML view file using {{ comments() }}
		 */
		$ApiFeed->get($feedId);

		return $Controller->title('Comments & Likes')
			->section('PHPfox App Base', '/base')
			->h1('Comments & Likes', '/base/comments-and-likes')
			->menu($Base->menu())->render('comments-and-likes.html');
	});

	/**
	 * @route /base/phrasing
	 * Working with Phrases
	 */
	new Core\Route('/phrasing', function(Core\Controller $controller) use($Base) {

		return $controller->title('Phrases')
			->section('PHPfox App Base', '/base')
			->h1('Phrases', '/base/comments-and-likes')
			->menu($Base->menu())->render('phrasing.html', [
				'thePhrase' => _p('core.sample_phrase')
			]);
	});

	/**
	 * @route /base/is
	 * Working with Is.*
	 */
	new Core\Route('/is', function(Core\Controller $controller) use($Base) {

		if (Core\Is::module('blog')) {
			// check to see if a module is enabled
		}

		if (Core\Is::user()) {
			// check to see if a user is logged in
		}

		if ($controller->active->perm('blog.add_new_blog')) {
			// check to see if a user has access to a specific user permission.
		}

		return $controller->title('IS Function')
			->section('PHPfox App Base', '/base')
			->h1('IS', '/base/is')
			->menu($Base->menu())->render('is.html');
	});

	/**
	 * @route /base/ajax
	 * Working with AJAX
	 */
	new Core\Route('/ajax', function(Core\Controller $controller) use($Base) {


		return $controller->title('AJAX')
			->section('PHPfox App Base', '/base')
			->h1('AJAX', '/base/ajax')
			->menu($Base->menu())->render('ajax.html');
	});

	/**
	 * @route /base/ajax-get
	 * Working with AJAX response
	 */
	new Core\Route('/ajax-get', function(Core\Controller $controller) use($Base) {

		return [
			'run' => "$('#ajax-response').html('<div class=\"message\">Hello World! Me is AJAX response.</div>');"
		];
	});

	/**
	 * @route /base/ajax-custom
	 * Working with AJAX response
	 */
	new Core\Route('/ajax-custom', function(Core\Controller $controller) use($Base) {

		echo '<div class="message">Well, hello again. I too am an AJAX response.</div>';
	});
});

/**
 * @route /api/PHPfox_Base
 * Here we build a route outside our /base group because it needs to connect to the cores API route.
 * We use this route to get the sections sub menu, which we have on all other sections.
 * Since the @route /base/external-controller is an external route, we don't have the menu locally and have to build
 * it with the API
 */
new Core\Route('/api/PHPfox_Base', function(Core\Controller $Controller) {
	$Controller->menu((new Base())->menu());

	return [
		'menu' => $Controller->menu()
	];
});