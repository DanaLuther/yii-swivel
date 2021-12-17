<?php
/**
 * SwivelLoaderTest.php
 *
 * @created 12/16/21
 * @version 1.0
 * @copyright (c) Envisage International, Corp.
 * @author Dana Luther <dluther@envisageinternational.com>
 * @yiiVersion 2.0.41
 */

namespace dhluther\YiiSwivel\tests\unit\components;

use dhluther\YiiSwivel\components\SwivelLoader;
use dhluther\YiiSwivel\components\SwivelLogger;
use dhluther\YiiSwivel\models\SwivelFeature;
use PHPUnit\Framework\TestCase;
use Zumba\Swivel\Config;
use Zumba\Swivel\Manager;

class SwivelLoaderTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		\Yii::app()->swivel->init();
	}

	public function testGetConfig()
	{

		$loader = new SwivelLoader([
			'BucketIndex' => 1,
			'LoaderAlias' => 'SwivelLoader',
			'Logger'      => new SwivelLogger(),
			'Metrics'     => null,
			'ModelAlias'  => SwivelFeature::class,
		]);
		self::assertInstanceOf(Config::class, $loader->getConfig());
		return $loader;
	}

	/**
	 * @return void
	 * @depends testGetConfig
	 */
	public function testGetManager(SwivelLoader $loader)
	{
		$manager = $loader->getManager();
		self::assertInstanceOf(Manager::class, $manager);
	}

	/**
	 * @return void
	 * @depends testGetConfig
	 */
	public function testSetBucketIndex(SwivelLoader $loader)
	{
		$loader->setBucketIndex(5);
		$config = $loader->getConfig();
		self::assertEquals(5, $config->getBucket()->getIndex());
	}
}
