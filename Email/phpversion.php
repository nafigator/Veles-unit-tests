<?php
/**
 * Function stub for test EmailNotifier class
 *
 * @file      phpversion.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2021-05-02 21:11
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler\Subscribers;

use Veles\Tests\Email\AbstractEmailTest;

function phpversion(): string
{
	return AbstractEmailTest::PHP_VERSION;
}
