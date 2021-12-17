<?php
/**
 * SwivelComponentTest.php
 *
 * @created 12/16/21
 * @version 1.0
 * @copyright (c) Envisage International, Corp.
 * @author Dana Luther <dluther@envisageinternational.com>
 * @yiiVersion 2.0.41
 */

namespace dhluther\YiiSwivel\tests\unit\components;

use dhluther\YiiSwivel\components\SwivelComponent;
use PHPUnit\Framework\TestCase;
use Zumba\Swivel\Builder;

class SwivelComponentTest extends TestCase
{


	public function testInit()
	{
		\Yii::app()->swivel->init();
		self::assertInstanceOf(SwivelComponent::class, \Yii::app()->swivel);
	}

	/**
	 * @depends testInit
	 */
	public function testForFeature()
	{
		$builder = \Yii::app()->swivel->forFeature('TestFeature');
		self::assertInstanceOf(Builder::class, $builder);
	}

	/**
	 * @depends testInit
	 * @see SwivelComponent::invoke()
	 */
	public function testInvoke()
	{
		$enabled = \Yii::app()->swivel->invoke('TestFeature', fn()=>'A', fn()=>'B');
		self::assertEquals('B', $enabled);
	}

	/**
	 * @depends testInit
	 */
	public function testReturnValue()
	{
		$enabled = \Yii::app()->swivel->returnValue('TestFeature', true, false);
		self::assertEquals(false, $enabled);
	}
}
