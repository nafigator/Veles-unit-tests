<?php
/**
 * Function stub for test MemcacheRaw class
 *
 * @file      fgets_stub.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-10-20 18:24
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

function fgets($handle)
{
	if ($handle['host'] === 'VELES_UNIT_TEST_DEL_BY_TEMPLATE') {
		static $del_template;

		if (null === $del_template) {
			$del_template = 0;
		}

		++$del_template;

		switch ($del_template) {
			case 1:
				return "STAT items:3:number 5\r\n";
			case 2:
				return "STAT items:3:age 0\r\n";
			case 3:
				return "STAT items:3:evicted 0\r\n";
			case 4:
				return "STAT items:3:evicted_nonzero 0\r\n";
			case 5:
				return false;
			case 6:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be279a8a [13 b; 1508514796 s]\r\n";
			case 7:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be2799a8 [13 b; 1508514796 s]\r\n";
			case 8:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be279903 [13 b; 1508514796 s]\r\n";
			case 9:
				return "ITEM VELES::UNIT-TEST::49ea1be2795cd::59ea1be279903 [13 b; 1508514796 s]\r\n";
			case 10:
				return false;
		}

		return false;
	} elseif ($handle['host'] === 'VELES_UNIT_TEST_QUERY') {
		static $query;

		if (null === $query) {
			$query = 0;
		}

		++$query;

		switch ($query) {
			case 1:
				return "VALUE VELES::UNIT-TEST::59ea24a876add 1 3\r\n";
			case 2:
				return "434\r\n";
			case 3:
				return "END\r\n";
			case 4:
				return false;
		}

		return false;
	} elseif ($handle['host'] === 'VELES_UNIT_TEST_MEMCACHED_ADAPTER') {
		static $adapter;

		if (null === $adapter) {
			$adapter = 0;
		}

		++$adapter;

		switch ($adapter) {
			case 1:
				return "STAT items:3:number 5\r\n";
			case 2:
				return "STAT items:3:age 0\r\n";
			case 3:
				return "STAT items:3:evicted 0\r\n";
			case 4:
				return "STAT items:3:evicted_nonzero 0\r\n";
			case 5:
				return false;
			case 6:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be279a8a [13 b; 1508514796 s]\r\n";
			case 7:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be2799a8 [13 b; 1508514796 s]\r\n";
			case 8:
				return "ITEM VELES::UNIT-TEST::59ea1be2795cd::59ea1be279903 [13 b; 1508514796 s]\r\n";
			case 9:
				return "ITEM VELES::UNIT-TEST::49ea1be2795cd::59ea1be279903 [13 b; 1508514796 s]\r\n";
			case 10:
				return false;
		}

		return false;
	}

	return true;
}
