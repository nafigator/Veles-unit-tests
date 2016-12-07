<?php
namespace Veles\Tests\Exceptions\Http;

use Veles\Exceptions\Http\RuntimeException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-09-30 at 14:58:36.
 * @group exceptions
 */
class RuntimeExceptionTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct()
	{
		new RuntimeException();
		$msg = 'RuntimeException::__construct() wrong behavior!';
		$this->assertSame(500, http_response_code(), $msg);
	}
}
