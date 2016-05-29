<?php
/**
 * Class for stubbing \PDO
 *
 * @file      PDOStub.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-05-29 06:36
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\DataBase\Connections;

/**
 * Class   PDOStub
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class PDOStub extends \PDO
{
	protected $attributes = [];

	public function __construct() {}

	public function setAttribute($attribute, $value)
	{
		$this->attributes[$attribute] = $value;
	}

	public function getAttribute($attribute)
	{
		return isset($this->attributes[$attribute])
			? $this->attributes[$attribute]
			: null;
	}
}
