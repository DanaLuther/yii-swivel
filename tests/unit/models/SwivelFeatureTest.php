<?php
/**
 * SwivelFeatureTest.php
 *
 * @created 12/16/21
 * @version 1.0
 * @copyright (c) Envisage International, Corp.
 * @author Dana Luther <dluther@envisageinternational.com>
 * @yiiVersion 2.0.41
 */

namespace dhluther\YiiSwivel\tests\unit\models;

use dhluther\YiiSwivel\models\SwivelFeature;
use PHPUnit\Framework\TestCase;

class SwivelFeatureTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		\Yii::app()->swivel->init();
	}
	protected function tearDown(): void
	{
		\Yii::app()->db->createCommand()->truncateTable('swivel');
		parent::tearDown();
	}

	public function testModel()
	{
		$model = new SwivelFeature();
		self::assertInstanceOf(SwivelFeature::class, $model);
		self::assertTrue($model->validate());

		$model->slug = 'TestFeature';
		$model->buckets = '1,2,3,4,5,6,7,8,9,10';
		self::assertTrue($model->save());
		self::assertEquals(1, SwivelFeature::model()->count());
	}

	public function testGetBucketData()
	{
		$model = SwivelFeature::model();
		$model->slug = 'TestFeature';
		$model->buckets = '1,2,3,4,5,6,7,8,9,10';
		$bucket_data = $model->getBucketData();
		self::assertIsArray($bucket_data);
		self::assertCount(10, $bucket_data);
	}

	/**
	 * @depends testModel
	 */
	public function testGetMapData()
	{
		$model = new SwivelFeature();
		$model->slug = 'TestFeature';
		$model->buckets = '1,2,3,4,5,6,7,8,9,10';
		self::assertTrue($model->save());
		$mapData = $model->getMapData();
		self::assertIsArray($mapData);
		self::assertArrayHasKey('TestFeature', $mapData);
		self::assertCount(10, $mapData['TestFeature']);
	}
}
