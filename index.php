<?php

// composer autoloader for required packages and dependencies
require_once('lib/autoload.php');

/** @var \Base $f3 */
$f3 = \Base::instance();

$f3->set('AUTOLOAD', 'app/');

$f3->set('Config', new \Services\Config($f3));

$f3->get('Config')->init();

// Home and pagination.
$f3->route(array(
	'GET /',
	'GET /page/@page',
),'\Controllers\Blog->home');

// Single page.
$f3->route(array(
	'GET /@blogTitle',
	'GET /@blogTitle/page/@page',
),'\Controllers\Blog->single');

// Forum.
$f3->route(array(
	'GET /forum/',
	'GET /forum/page/@page',
),'\Controllers\Forum->home');

// JS and Css minification.
$f3->route('GET /minify/@type',
	function($f3, $args)
	{
		$path = $f3->get('UI') . $args['type'] .'/';
		$files = preg_replace('/(\.+\/)/','', $f3->clean($f3->get('GET.files')));
		echo Web::instance()->minify($files, null, true, $path);
	},
	3600*24
);

$f3->run();
