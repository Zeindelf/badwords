<?php

namespace Badwords\Tests;

use Badwords\Badwords;

class BadwordsTest extends \PHPUnit_Framework_TestCase
{
	public function testIgnoreBadwords()
	{
		$extra = [
			'ignored' => ['arrombado', 'baitola'],
		];

		$ignoreOne = 'arrombado';
		$ignoreTwo = 'baitola';
		$verifyOne = Badwords::verify($ignoreOne, $extra);
		$verifyTwo = Badwords::verify($ignoreTwo, $extra);

		$this->assertFalse($verifyOne);
		$this->assertFalse($verifyTwo);
	}

	public function testMoreBadwords()
	{
		$extra = [
			'badwords' => ['rocks', 'zeindelf'],
		];

		$badwordsOne = 'rocks';
		$badwordsTwo = 'zeindelf';
		$verifyOne = Badwords::verify($badwordsOne, $extra);
		$verifyTwo = Badwords::verify($badwordsTwo, $extra);

		$this->assertTrue($verifyOne);
		$this->assertTrue($verifyTwo);
	}

	public function testCatchBadwordsMixed()
	{
		$badwords = '@@@@44rrooo0000MMmmMmBBbb88ß@@ªªäá4dÐÐòòöoo000ººº';
		$verify = Badwords::verify($badwords);

		$this->assertTrue($verify);
	}

	public function testCatchBadwordsBySpecialChars()
	{
		$badwords = '@rr0mß4dº';
		$verify = Badwords::verify($badwords);

		$this->assertTrue($verify);
	}

	public function testCatchBadwordsByRepeatedChars()
	{
		$badwords = 'aaarrrrrooommmbbbbaaaaddddddooooo';
		$verify = Badwords::verify($badwords);

		$this->assertTrue($verify);
	}

	public function testExistsBadwords()
	{
		$badwords = 'arrombado';
		$verify = Badwords::verify($badwords);

		$this->assertTrue($verify);
	}

	public function testDontExistsBadwords()
	{
		$badwords = 'rocks';
		$verify = Badwords::verify($badwords);

		$this->assertFalse($verify);
	}
}