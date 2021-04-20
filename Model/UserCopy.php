<?php
/**
 * Testing float and default properties types in QueryBuilder::sanitize()
 *
 * @file    UserCopy.php
 *
 * PHP version 7.1+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-27 17:42
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Model;

use Model\Type;
use Veles\Model\User;

/**
 * Class UserCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UserCopy extends User
{
	protected $map = [
		'id'         => Type::INT,
		'email'      => Type::STRING,
		'hash'       => Type::STRING,
		'group'      => Type::INT,
		'last_login' => Type::STRING,
		'money'      => Type::FLOAT,
	];
}
