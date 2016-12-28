<?php

namespace Models;

class Blog
{
	function __construct()
	{
		$this->f3 = \Base::instance();
		$this->mapper = new \DB\SQL\Mapper($this->f3->get('DB'),'suki_c_message');
	}

	function getComments()
	{

	}

	function getEntries($params = array())
	{
		return $this->f3->get('DB')->exec('
			SELECT m.msgTime, m.title, m.url
			FROM suki_c_topic AS t
			LEFT JOIN suki_c_message AS m ON (m.msgID = t.fmsgID)
			WHERE boardID = :board
			ORDER BY m.msgID DESC
			LIMIT :start, :limit', array(
			':limit' => $params['limit'],
			':start' => ($params['start'] * $params['limit']),
			':board' => $params['board'],
		));
	}
}