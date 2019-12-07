<?php

	return [
		'account/login' => [
			'controller' => 'account',
			'action' => 'login',
		],

		'account/register' => [
			'controller' => 'account',
			'action' => 'register',
		],

		'account/verify' => [
			'controller' => 'account',
			'action' => 'verify',
		],

		'profile/createPhoto' => [
			'controller' => 'profile',
			'action' => 'createPhoto',
		],

		'profile/settings' => [
			'controller' => 'profile',
			'action' => 'settings',
		],

		'' => [
			'controller' => 'main',
			'action' => 'index',
		],

	];