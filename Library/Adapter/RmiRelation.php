<?php
namespace Rmi\Library\Adapter;

class RmiRelation extends Rmi
{
	private $redisKey = null;
	private $redisIndexKey = null;

	public function __construct()
	{
		parent::__construct();

		// TODO: isHandleDataValid function needed

		// rmi:[type]:cached
		$this->redisKey = $this->generateKey(array(
			$this->getHandleDataValue('type'),
			'relation'
		));
	}

	public function find()
	{

	}

	public function update()
	{

	}

	public function delete()
	{

	}

	public function count()
	{

	}
}