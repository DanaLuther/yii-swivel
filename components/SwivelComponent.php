<?php

/** 
 * SwivelComponent.php
 *
 * @created 3/17/16 
 * @version 1.0
 * @author Dana Luther <dana.luther@gmail.com>
 * @yiiVersion 1.1.17
 */
/**
 * SwivelComponent
 *
 * @see http://www.yiiframework.com/docs/api/1.1/CApplicationComponent
 * @author Dana Luther <dana.luther@gmail.com>
 * @version 1.0
 * @yiiVersion 1.1.17
 */
class SwivelComponent extends CApplicationComponent {

	/** @var SwivelLoader */
	protected $loader;
	public $options = [];
	public $autoCreateSwivelTable = true;
	public $autoLoad = true;
	public $swivelTableAlias = 'swivel';
	public $modelClass = 'SwivelFeature';
	public $cookieName = 'Swivel_Bucket';
	public $dbComponent = 'db';
	public $vendorDir = 'vendor';

	public $extensionAlias = 'application.extensions.swivel';

	public function init()
	{
		parent::init();

		Yii::import( $this->extensionAlias.'.models.*');
		Yii::import( $this->extensionAlias.'.components.*');

		if ( $this->autoLoad )
		{
			require_once( Yii::getPathOfAlias( $this->extensionAlias ) . DIRECTORY_SEPARATOR . $this->vendorDir . DIRECTORY_SEPARATOR . 'autoload.php' );
		}

		if ( $this->autoCreateSwivelTable )
		{
			/** @var CDbConnection $db */
			$db = Yii::app()->getComponent( $this->dbComponent );
			try {
				$db->createCommand()->delete( $this->swivelTableAlias, '0=1');
			} catch ( Exception $e )
			{
				$this->initSwivelTable( $db, $this->swivelTableAlias );
			}
		}

		$this->loader = new SwivelLoader( CMap::mergeArray( $this->getDefaultOptions(), $this->options ));


	}

	/**
	 * @param $slug
	 *
	 * @return \Zumba\Swivel\Builder
	 */
	public function forFeature( $slug )
	{
		return $this->loader->getManager()->forFeature( $slug );
	}

	/**
	 * Syntactic sugar for creating simple feature toggles (ternary style)
	 *
	 * @param string $slug
	 * @param mixed $a
	 * @param mixed $b
	 * @return mixed
	 */
	public function invoke($slug, $a, $b = null) {
		return $this->loader->getManager()->invoke($slug, $a, $b);
	}

	/**
	 * Default configuration options for the Loader
	 *
	 * @return array
	 */
	protected function getDefaultOptions()
	{
		return [
			'Cookie' => [
				'name' => $this->cookieName,
				'expire' => 0,
				'path' => '/',
				'domain' => Yii::app()->request->hostInfo,
				'secure' => false,
				'httpOnly' => false
			],
			'BucketIndex' => null,
			'LoaderAlias' => 'SwivelLoader',
			'Logger' => null,
			'Metrics' => null,
			'ModelAlias' => $this->modelClass,
		];
	}

	/**
	 * @param CDbConnection $db
	 * @param string $tableName
	 */
	protected function initSwivelTable( $db, $tableName  )
	{
		$db->createCommand()->createTable($tableName, [
				'id'=>'INT PRIMARY KEY AUTO_INCREMENT',
				'slug'=>'MEDIUMTEXT',   // enable more than 254 chars for slug since they have . subfeatures
				'buckets'=>'TINYTEXT',  // 10 bucket system, so never more than 18 chars currently
				'INDEX ix_slug( slug(8) )',
			]
		);
	}
}
