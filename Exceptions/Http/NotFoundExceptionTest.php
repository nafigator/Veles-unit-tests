<?php
namespace Veles\Tests\Exceptions\Http;

use Veles\Exceptions\Http\NotFoundException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-09-13 at 14:28:12.
 * @group exceptions
 */
class NotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \Veles\Exceptions\Http\NotFoundException
	 */
	public function testConstruct()
	{
		new NotFoundException;
		$msg = 'NotFoundException::__construct() wrong behavior!';
		$this->assertSame(404, http_response_code(), $msg);
    }
}