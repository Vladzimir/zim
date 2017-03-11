<?php

namespace Controllers;

class User extends Base
{
	function profile(\Base $f3, $params)
	{
		// No user? redirect to the main page.
		if (empty($params['user']))
			return $f3->reroute('/');

		// Ugly, I know...
		$user = explode('-', $params['user']);

		// The ID will always be the last key. Since we're here, remove it.
		$id = array_pop($user);

		// Load the user's info.
		$f3->set('user', $this->_models['user']->load(['userID = ?', $id]));

		// Nothing was found!
		if ($this->_models['user']->dry())
		{
			\Flash::instance()->addMessage('no_user', 'danger');
			$f3->reroute('/');
		}

		// Latest topics.
		$f3->set('profileTopics', []);

		// Latest messages.latestMessages
		$f3->set('profileMessages', $this->_models['message']->userMessages([
			':user' => $id,
			':limit' => 5,
		]));

		$f3->set('site', $f3->merge('site', [
			'metaTitle' => $f3->get('txt.view_profile', $this->_models['user']->userName),
			'breadcrumb' => [
				['url' => '', 'title' => $f3->get('txt.view_profile', $this->_models['user']->userName), 'active' => true],
			],
		]));

		$f3->set('content','profile.html');
	}

	function settings(\Base $f3, $params)
	{

	}
}
