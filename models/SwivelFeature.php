<?php
/** 
 * SwivelFeature.php
 *
 * @created 3/17/16 
 * @version 1.0
 * @author Dana Luther <dana.luther@gmail.com>
 * @yiiVersion 1.1.17
 */
/** 
 * SwivelFeature
 *
 * @see http://www.yiiframework.com/docs/api/1.1/CActiveRecord
 * @author Dana Luther <dana.luther@gmail.com>
 * @version 1.0
 * @yiiVersion 1.1.17
 *
 * @property string $slug           Name of the feature
 * @property string $buckets        Comma separated list of bucket IDs
 * @property-read array $bucketData Array of bucket IDs associated with this feature
 */
class SwivelFeature extends CActiveRecord {

	const DELIMITER = ',';

	/**
	 * @param string $className
	 *
	 * @return SwivelFeature
	 */
	public static function model( $className=__CLASS__ )
	{
		return parent::model( $className );
	}

	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'swivel';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			['slug','safe'],    // MediumText by default
		    ['buckets','length','max'=>254], // Tinytext by default
		];
	}

	/**
	 * @return false|string[]
	 */
	public function getBucketData()
	{
		return explode( self::DELIMITER, $this->buckets );
	}

	/**
	 * Format data from the active record to the data swivel expects
	 *
	 * @return array
	 */
	protected function formatRow(  )
	{
		return [ $this->slug => $this->getBucketData() ];
	}

	/**
	 * Return an array of map data in the format that Swivel expects
	 *
	 * @return array
	 */
	public function getMapData()
	{
		$data = SwivelFeature::model()->findAll();
		if ( empty( $data ))
		{
			return[];
		}
		$map = [];
		foreach( $data as $row )
		{
			$map = CMap::mergeArray($map, $row->formatRow() );
		}
		return $map;
	}
}