<?php
/**
 * @file    ViewAdapterAbstractChild.php
 *
 * PHP version 7.1+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-19 12:03
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\View\Adapters;

use Veles\View\Adapters\ViewAdapterAbstract;

/**
 * Class ViewAdapterAbstractChild
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ViewAdapterAbstractChild extends ViewAdapterAbstract
{
	/**
	 * Driver initialization
	 */
	protected function __construct()
	{
		$this->setDriver($this);
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	public function get($path)
	{
		return '';
	}

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 * @return bool Cache status
	 */
	public function isCached($tpl)
	{
		return true;
	}

	public function addCalls($calls)
	{
		self::$calls = $calls;
	}

	public function setInstance($instance)
	{
		self::$instance = $instance;
	}

	public function getCalls()
	{
		return self::$calls;
	}

	public function testCall($param)
	{
	}
}
