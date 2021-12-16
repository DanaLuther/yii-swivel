<?php
/**
 * SwivelLogger.php
 *
 * Some of the log levels are not supported by the yii logger natively, we redirect them to error level
 *
 * @created       3/18/16
 * @version       1.1
 * @author        Dana Luther <dana.luther@gmail.com>
 * @yiiVersion    1.1.17
 */
class SwivelLogger extends \Psr\Log\AbstractLogger
{
	public $category = 'application.swivel';

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 * @return void
	 */
	public function log($level, $message, array $context = array()){
		Yii::log( $message.PHP_EOL.CVarDumper::dumpAsString($context), $level , $this->category );
	}
}
