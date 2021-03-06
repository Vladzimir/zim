<?php

namespace Services;

class Config
{
	function __construct(\Base $f3)
	{
		$this->f3 = $f3;
	}

	function init()
	{
		$this->f3->set('DB', new \DB\SQL(
			$this->f3->get('_db.type') .':host='. $this->f3->get('_db.host') .';port='. $this->f3->get('_db.port') .';dbname='. $this->f3->get('_db.name') .'',
			$this->f3->get('_db.user'),
			$this->f3->get('_db.password'),
			[\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4;']
		));

		$this->f3->mset([
			'URL' => 'https://missallsunday.com/',
			'Logs' => 'logs/',
			'CACHE' => $this->f3->get('_memcached'),
			'DEBUG' => 0,
			'PREFIX' => 'txt.',
			'ENCODING' => 'UTF-8',
			'LOCALES' => 'dict/',
			'LANGUAGE' => 'en-US',
			'UI' => 'views/',
			'SCHEME' => 'https',
			'TZ' => 'America/Mexico_City',
			'site' => array(
				'home' => 'Miss All Sunday',
				'title' => 'Miss All Sunday',
			),
			'paginationLimit' => 10,
		]);

		// This should be automatically set.... @todo
		$this->f3->set('Tools', new \Services\Tools($this->f3));

		// Set default metadata tags and/or other common HTML tags.
		$this->f3->set('site.currentUrl', $this->f3->get('URL'));
		$this->f3->set('site.metaTitle', 'Miss All Sunday - Index');
		$this->f3->set('site.keywords', $this->f3->get('txt.site_keywords'));
		$this->f3->set('site.description', $this->f3->get('txt.site_desc'));

		// Declare these as an empty array.
		$this->f3->set('site.customJS', []);
		$this->f3->set('site.customCSS', []);

		// Get the user if theres any.
		$this->f3->set('REMEMBER', new \Models\Remember($this->f3->get('DB')));
	}
}
