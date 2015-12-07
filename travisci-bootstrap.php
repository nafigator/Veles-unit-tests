<?php
/**
 * @file      travisci-bootstrap.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2014-12-24 09:59
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests;

use PDO;
use Veles\AutoLoader;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Cache\Cache;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;
use Veles\DataBase\Db;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));

date_default_timezone_set('Europe/Moscow');

require LIB_DIR . '/Veles/AutoLoader.php';
AutoLoader::init();
AutoLoader::registerPath(
	[LIB_DIR, TEST_DIR, realpath(__DIR__ . '/Project')]
);

$view_adapter = new NativeAdapter;
$view_adapter->setTemplateDir(TEST_DIR . '/Project/View/');
View::setAdapter($view_adapter);

// Cache initialization
MemcacheRaw::setConnectionParams('localhost', 11211);
MemcachedAdapter::addCall('addServer', ['localhost', 11211]);
MemcacheAdapter::addCall('addServer', ['localhost', 11211]);
Cache::setAdapter(MemcachedAdapter::instance());

// Parameters for Db connection
$pool = new ConnectionPool();
$conn1 = new PdoConnection('master');

// Database "test" must be created
$conn1->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('travis')
	->setPassword('')
	->setOptions([
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=ANSI'
	]);

// For testing exceptions thrown on connection errors
$conn2 = new PdoConnection('fake');
$conn2->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('fake-user')
	->setPassword('fake-password')
	->setOptions([
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=ANSI'
	]);

$pool->addConnection($conn1, true);
$pool->addConnection($conn2);
PdoAdapter::setPool($pool);

Db::setAdapter(PdoAdapter::instance());
