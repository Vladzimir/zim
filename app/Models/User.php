<?php

namespace Models;

class User extends \DB\SQL\Mapper
{
	public $userHref;

	function __construct(\DB\SQL $db)
	{
		$f3 = \Base::instance();

		parent::__construct($db, $f3->get('_db.prefix') . 'user');

		$this->isOnline = "last_active >= UNIX_TIMESTAMP() - 300";

		$this->onload(function($self) use($f3){
			$self->userHref = $f3->get('BASE') .'/user/'. $f3->get('Tools')->slug($self->userName) .'-'. $self->userID;
		});
	}

	public function getById($id = 0)
	{
		return $this->load(array('userID = ?', $id));
	}

	public function getByName($name = 0)
	{
		return $this->load(array('name = ?', $name));
	}

	public function getByEmail($email = '')
	{
		return $this->load(array('userEmail = ?', $email));
	}

	function loadUsers($users = [])
	{
		$loaded = $data = [];
		$data = $this->db->exec('
			SELECT userID, userName, avatar, avatarType, webUrl, webSite, lmsgID, last_active, (last_active >= UNIX_TIMESTAMP() - 300) AS isOnline
			FROM '. $this->table() .' AS t
			LEFT JOIN suki_c_message AS m ON (m.msgID = t.fmsgID)
			WHERE userID IN(:users)
			AND is_active = 1', [
			':users' => implode(',', $users),
		]);

		if (!empty($data))
			foreach ($data as $d)
				$loaded[$d['userID']] = $d;

		return $loaded;
	}

	function createUser($data = [])
	{
		$f3 = \Base::instance();

		if (empty($data))
			return false;

		// Get what we need
		$data = array_map(function($var) use($f3){
			return $f3->clean($var);
		}, array_intersect_key(array_flip($this->fields())));

		$this->copyfrom($data);

		// Thats pretty much it.
		$this->save();
	}
}