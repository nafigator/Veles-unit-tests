<?php
/**
 * Function stub for test AbstractEmail class
 *
 * @file      mail.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2021-05-02 20:08
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Email;

use PHPUnit\Framework\TestCase;
use Veles\Tests\Email\AbstractEmailTest;

function mail($receiver, $subject, $message, $headers): bool
{
	if (
		$receiver === AbstractEmailTest::RECEIVER
		&& $subject === AbstractEmailTest::ENCODED_SUBJECT
		&& $message === AbstractEmailTest::MESSAGE
		&& $headers === AbstractEmailTest::HEADERS
	) {
		return true;
	}

	$msg = 'Expected:' . PHP_EOL
		. AbstractEmailTest::RECEIVER . PHP_EOL
		. AbstractEmailTest::ENCODED_SUBJECT . PHP_EOL
		. AbstractEmailTest::MESSAGE . PHP_EOL
		. AbstractEmailTest::HEADERS . PHP_EOL
	    . 'Actual:' . PHP_EOL
		. $receiver . PHP_EOL
		. $subject . PHP_EOL
		. $message . PHP_EOL
		. $headers . PHP_EOL
	;

	TestCase::fail($msg);
}
