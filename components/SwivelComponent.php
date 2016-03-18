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
	/** @var array Options to be passed to the Config */
	public $options = [];
	
	/** @var bool Whether to create the swivel table automatically when it does not exist */
	public $autoCreateSwivelTable = true;
	/** @var string The table name to be used to store the swivel features and associated buckets */
	public $swivelTableAlias = 'swivel';
	/** @var string The Application component ID for the swivel database connection */
	public $dbComponent = 'db';

	/** @var string The class name for the model holding the swivel map data  */
	public $modelClass = 'SwivelFeature';

	/** @var string The name of the vendor directory where swivel is installed */
	public $vendorDir = 'vendor';
	/** @var string The alias for the location of this extension */
	public $extensionAlias = 'application.vendor.dhluther.yii-swivel';

	/** @var string The default Cookie to store the swivel bucket information for the user */
	public $cookieName = 'Swivel_Bucket';
	/** @var string The name of the property on the application user model that holds their assigned bucket identifier */
	public $userBucketProperty = 'bucketIndex';
	/** @var null|int The default bucket ID - if null, one will be randomly generated and assigned */
	public $bucketIndex = null;

	public function init()
	{
		parent::init();

		Yii::import( $this->extensionAlias.'.models.*');
		Yii::import( $this->extensionAlias.'.components.*');

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

		// If we have a registered user, assume they should have some property or magic method that holds their bucket ID
		if ( !Yii::app()->user->isGuest )
		{
			$this->bucketIndex = Yii::app()->user->{$this->userBucketProperty};
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
	 * Shorthand syntactic sugar for invoking a simple feature behavior using Builder::addValue.
	 * Useful for ternary style code.
	 *
	 * @param $slug
	 * @param $a
	 * @param null $b
	 *
	 * @return mixed
	 */
	public function returnValue( $slug, $a, $b=null ) {
		return $this->loader->getManager()->returnValue($slug, $a, $b );
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
			'BucketIndex' => $this->bucketIndex,
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
