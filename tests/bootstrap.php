<?php
/**
 * bootstrap.php
 */

$appBaseDir = dirname(__FILE__);

$yiit = $appBaseDir . '/../vendor/yiisoft/yii/framework/yiit.php';
require_once($yiit);
require_once($appBaseDir . '/../vendor/autoload.php');

$config = [
	'id'         => 'Swivel Test',
	'basePath'   => $appBaseDir . '/../',
	'components' => [
		'user'    => [
			'class' => CWebUser::class,
		],
		'session' => [
			'class' => CHttpSession::class,
		],
		'db'      => [
			'class'            => CDbConnection::class,
			'connectionString' => "sqlite:$appBaseDir/testdata.sqlite",
		],
		'swivel'  => [
			'class' => \dhluther\YiiSwivel\components\SwivelComponent::class,
		]
	]
];
Yii::createWebApplication($config);
