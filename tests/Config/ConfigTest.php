<?php

namespace Badwords\Tests\Config;

use Badwords\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
	public function testGetValueOnArray()
	{
		Config::set('arrayTwo', [
			'firstKey' => [
				'secondKey' => 'Valor da segunda chave',
			],
		]);

		$value = Config::get('arrayTwo.firstKey.secondKey');

		$this->assertEquals($value, 'Valor da segunda chave');
	}

	public function testExistsKeyOnArray()
	{
		Config::set('arrayOne', [
			'keyOne' => [
				'keyTwo' => [
					'keyThree' => ' ',
				],
			],
		]);

		$exists = Config::exists('arrayOne.keyOne.keyTwo.keyThree');

		$this->assertTrue($exists);
	}

	public function testExistsKey()
	{
		$key = Config::set('arrayOne', [
				'keyOne' => ' ',
			]);

		$this->assertArrayHasKey('keyOne', $key);
	}
}