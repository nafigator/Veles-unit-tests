<?php
/**
 * Environment initialisation for unit-tests
 *
 * Launch test in root directory:
 * phpunit
 * Unit-tests skeletons generation:
 * phpunit-skelgen --bootstrap="Tests/bootstrap.php" generate-test "Veles\View\Adapters\CustomJsonAdapter" "Veles/View/Adapters/CustomJsonAdapter.php" "Veles\Tests\View\Adapters\CustomJsonAdapterTest" "Tests/View/Adapters/CustomJsonAdapterTest.php"
 *
 * @file      bootstrap-example.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Чтв Дек 20 12:22:58 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests;

use Veles\AutoLoader;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');

define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));

date_default_timezone_set('Europe/Moscow');

require LIB_DIR . '/Veles/AutoLoader.php';
$includes = LIB_DIR . ':' . TEST_DIR . ':' . realpath(__DIR__ . '/Project');
set_include_path(implode(PATH_SEPARATOR, [$includes, get_include_path()]));

AutoLoader::init();

$view_adapter = NativeAdapter::instance();
$view_adapter->setTemplateDir(TEST_DIR . '/Project/View/');
View::setAdapter($view_adapter);
