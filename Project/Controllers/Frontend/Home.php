<?php
/**
 * Контроллер для теста Application
 * @file    Home.php
 *
 * PHP version 5.6+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Птн Янв 25 05:49:20 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Controllers\Frontend;

use Veles\Controllers\BaseController;

/**
 * Класс Home
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Home extends BaseController
{
	protected $route;

	/**
	 * Метод вызываемый при запросе /index.html
	 */
	public function index()
	{
		return [
			'a' => 'Test',
			'b' => 'complete',
			'c' => 'Hello',
		];
	}

	/**
	 * Метод вызываемый при запросе /book/5/user/3
	 */
	public function book()
	{
		return [
			'book' => $this->getParam('book_id'),
			'user' => $this->getParam('user_id')
		];
	}

	/**
	 * @return mixed
	 */
	public function getRoute()
	{
		return $this->getApplication()->getRoute();
	}

	/**
	 * @param mixed $route
	 */
	public function setRoute($route)
	{
		$this->getApplication()->setRoute($route);
	}

	public function read()
	{
		$definitions = [
			'email'    => [
				'filter'  => FILTER_VALIDATE_EMAIL,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => ['required' => true]
			],
			'password' => [
				'filter'  => FILTER_VALIDATE_REGEXP,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => [
					'required' => true,
					'regexp'   => '/.{6,32}/'
				]
			]
		];

		return $this->getData($definitions);
	}
}
