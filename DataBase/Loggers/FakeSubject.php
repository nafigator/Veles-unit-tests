<?php
namespace Veles\Tests\DataBase\Loggers;

use SplObserver;
use Veles\DataBase\Adapters\DbAdapterInterface;
use Veles\DataBase\ConnectionPools\ConnectionPool;

/**
 * Class FakeSubject
 *
 * Нужен для тестирования класса PdoErrorLogger
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @group database
 */
class FakeSubject implements \SplSubject, DbAdapterInterface
{
	private $resource;
	private $stmt;

	public function attach(SplObserver $observer)
	{
	}

	public function detach(SplObserver $observer)
	{
	}


	public function notify()
	{
	}

	/**
	 * @return mixed
	 */
	public function getResource()
	{
		return $this->resource;
	}

	/**
	 * @param mixed $resource
	 */
	public function setResource($resource)
	{
		$this->resource = $resource;
	}

	/**
	 * @return mixed
	 */
	public function getStmt()
	{
		return $this->stmt;
	}

	/**
	 * @param mixed $stmt
	 */
	public function setStmt($stmt)
	{
		$this->stmt = $stmt;
	}

	/**
	 * Add connection pool
	 *
	 * @param ConnectionPool $pool
	 */
	public function setPool(ConnectionPool $pool)
	{
	}

	/**
	 * Get connection pool
	 */
	public function getPool()
	{
	}

	/**
	 * Set default connection
	 *
	 * @param string $name Connection name
	 */
	public function setConnection($name)
	{
	}

	/**
	 * Get value from table row
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return mixed
	 */
	public function value($sql, array $params, $types)
	{
	}

	/**
	 * Get table row
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return mixed
	 */
	public function row($sql, array $params, $types)
	{
	}

	/**
	 * Get result collection
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return mixed
	 */
	public function rows($sql, array $params, $types)
	{
	}

	/**
	 * Transaction initialization
	 */
	public function begin()
	{
	}

	/**
	 * Transaction rollback
	 */
	public function rollback()
	{
	}

	/**
	 * Commit transaction
	 */
	public function commit()
	{
	}

	/**
	 * Launch non-SELECT query
	 *
	 * @param string      $sql    Non-SELECT SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 */
	public function query($sql, array $params, $types)
	{
	}

	/**
	 * Get last saved ID
	 */
	public function getLastInsertId()
	{
	}

	/**
	 * Get found rows quantity
	 */
	public function getFoundRows()
	{
	}

	/**
	 * Escape variable
	 *
	 * @param string $var
	 */
	public function escape($var)
	{
	}
}
