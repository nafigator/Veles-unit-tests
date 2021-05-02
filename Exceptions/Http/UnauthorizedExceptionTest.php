<?php
namespace Veles\Tests\Exceptions\Http;

use PHPUnit\Framework\TestCase;
use Veles\Exceptions\Http\UnauthorizedException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-09-13 at 14:56:42.
 * @group exceptions
 */
class UnauthorizedExceptionTest extends TestCase
{
	public function testConstruct()
	{
		new UnauthorizedException;
		$msg = 'UnauthorizedException::__construct() wrong behavior!';
		self::assertSame(401, http_response_code(), $msg);

		//$expected = 'WWW-Authenticate: Basic realm="Application Name"';
		//$result   = '';
		//
		//foreach (headers_list() as $header) {
		//	if (strstr($header, 'WWW-Authenticate:')) {
		//		$result = $header;
		//		break;
		//	}
		//}
		//
		//self::assertSame($expected, $result, $msg);
	}
}
