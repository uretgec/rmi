<?php
include "autoload.php";

use Rmi\Rmi;
use Rmi\RmiException;

try
{
	// Config
	$config = array(
		// host, port, auth, db
		array('127.0.0.1', 6379, null, 0)
	);

	// HandleData
	$handleData = array(
		'type' => 'matchresult',
		'patterns' => array(
			Rmi::REDIS_KEY_LIMIT => '[id]',
			Rmi::REDIS_KEY_CACHE => '[paged][perpage]',
			Rmi::REDIS_KEY_STORAGE => '[key][id]'
		),
		'id' => 123123,
		'keys' => array(
			'goal' => Rmi::RMI_STORAGE_INCR,
			'win' => Rmi::RMI_STORAGE_INCR,
			'due_count' => Rmi::RMI_STORAGE_DECR,
			'matchtime' => Rmi::RMI_STORAGE_TIMESTAMP,
			'blocktime' => Rmi::RMI_STORAGE_EXPIRE
		),
		'page' => 2,
		'perpage' => 20
	);

	// Init RmiManager
	$rmiManager = new Rmi($config, $handleData);

	// RmiCache
	$cacheData = $rmiManager->findByCache();
	if(!$cacheData) {

		// RmiLimit
		for ($i=0;$i<=52;$i++) {
			$rmiManager->updateByLimit(array('key'=>'value', 'id' => $i));
		}
		$cacheData = $rmiManager->findByLimit(0, 5);
		$rmiManager->updateByCache($cacheData, 60);
	}

	var_dump($cacheData);

	// RmiStorage
	$rmiManager->updateByStorage(array(
		'goal' => 4,
		'win' => 1,
		'matchtime' => time(),
		'due_count' => 2,
		'blocktime' => 25
	));

	$hashData = $rmiManager->findByStorage();
	$rmiManager->deleteByStorage('due_count');
	$rmiManager->deleteByStorage(array('due_count', 'blocktime'));
	var_dump($hashData);

	// RmiDebug
	$rmiManager->debug();

} catch (RmiException $rmiException) {
	echo $rmiException->getRmiMessage();
}