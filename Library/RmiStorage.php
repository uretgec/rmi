<?php
namespace Rmi\Library;

// TODO: not finished.
class RmiStorage extends Rmi
{
	private $redisKey = null;
	private $redisIndexKey = null;

	public function __construct()
	{
		parent::__construct();

		// rmi:[type]:cached
		$this->redisKey = $this->generateKey(array(
			$this->getHandleDataValue('type'),
			'storage'
		));
	}

	public function find()
	{
		$storageData = (is_array($this->redisIndexKey))
			? $this->redis->hMGet($this->redisKey, $this->redisIndexKey)
			: $this->redis->hGet($this->redisKey, $this->redisIndexKey)
		;

		return $storageData;
	}

	public function update($storageData = null, $lifetime = 360)
	{

	}

	public function delete()
	{
		return (is_array($this->redisIndexKey))
			? call_user_func_array(array($this->redis, 'hDel'), array_merge($this->redisKey, $this->redisIndexKey))
			: $this->redis->hDel($this->redisKey, $this->redisIndexKey)
		;
	}

	public function count()
	{
		return $this->redis->hLen($this->redisKey);
	}
}