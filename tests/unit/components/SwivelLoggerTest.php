<?php
/**
 * SwivelLoggerTest.php
 *
 * @created 12/16/21
 * @version 1.0
 * @copyright (c) Envisage International, Corp.
 * @author Dana Luther <dluther@envisageinternational.com>
 * @yiiVersion 2.0.41
 */

namespace dhluther\YiiSwivel\tests\unit\components;

use dhluther\YiiSwivel\components\SwivelLogger;
use PHPUnit\Framework\TestCase;

class SwivelLoggerTest extends TestCase
{

	public function testLog()
	{
		\Yii::getLogger()->flush(true);

		self::assertCount(0, \Yii::getLogger()->logs);
		$m = new SwivelLogger();
		$m->log('info', 'Testing Swivel Logger log call');
		self::assertCount(1, \Yii::getLogger()->logs);
	}
}
