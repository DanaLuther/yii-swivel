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
	 * System is unusable.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function emergency($message, array $context = array())
	{
		$this->log( 'error', $message, $context);
	}

	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function alert($message, array $context = array())
	{
		$this->log( 'error', $message, $context);
	}

	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function critical($message, array $context = array())
	{
		$this->log( 'error', $message, $context);
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function log($level, $message, array $context = array()){
		return Yii::log( $message.PHP_EOL.CVarDumper::dumpAsString($context), $level , $this->category );
	}
}