<?php
/**
 * @file    UserCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-27 17:42
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Model;

use Veles\Model\User;

/**
 * Class UserCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UserCopy extends User
{
	protected $map = [
		'id'         => 'int',
		'email'      => 'string',
		'hash'       => 'string',
		'group'      => 'int',
		'last_login' => 'string',
		'money'      => 'float',
		'date'       => 'date'
	];
}
