<?php
namespace Veles\Tests\Exceptions\Http;

use PHPUnit\Framework\TestCase;
use Tests\Controllers\RestApiExampleController;
use Veles\Application\Application;
use Veles\Exceptions\Http\NotAllowedException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-12-25 at 17:24:55.
 * @group controllers
 */
class NotAllowedExceptionTest extends TestCase
{
	protected function tearDown(): void
	{
		unset($_SERVER['REQUEST_METHOD']);
	}

	public function testConstruct()
	{
		$_SERVER['REQUEST_METHOD'] = 'HEAD';

		new NotAllowedException(new RestApiExampleController(new Application));
		$msg = 'NotAllowedException::__construct() wrong behavior!';
		self::assertSame(405, http_response_code(), $msg);

		//$expected = 'Allowed: GET, POST, PUT, DELETE';
		//$actual   = '';
		//
		//foreach (headers_list() as $header) {
		//	if (strstr($header, 'Allowed:')) {
		//		$actual = $header;
		//		break;
		//	}
		//}
		//
		//self::assertSame($expected, $actual, $msg);
	}
}
