<?php
/**
 * @package SugiPHP.Profiler
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Profiler;

/**
 * Profiling Stopwatch Class
 */
class Stopwatch
{
	protected $startTime;
	protected $period = 0;

	/**
	 * Returns the stopwatch is running or not.
	 *
	 * @return boolean
	 */
	public function isRunning()
	{
		return $this->startTime > 0;
	}

	/**
	 * Start the stopwatch.
	 *
	 * @return self
	 * @throws SugiPHP\Profiler\Exception If the stopwatch is running
	 */
	public function start()
	{
		if ($this->startTime) {
			throw new Exception("Stopwatch is already running");
		}

		$this->startTime = microtime(true);

		return $this;
	}

	/**
	 * Stop the stopwatch.
	 *
	 * @return self
	 * @throws SugiPHP\Profiler\Exception If the stopwatch is running
	 */
	public function stop()
	{
		if (!$this->startTime) {
			throw new Exception("Stopwatch is not running");
		}

		$this->period += microtime(true) - $this->startTime;
		$this->startTime = 0;

		return $this;
	}

	/**
	 * Returns the period span from the start if the timer is running, or the last duration.
	 *
	 * @return integer
	 */
	public function getDuration()
	{
		if ($this->startTime) {
			return $this->period + microtime(true) - $this->startTime;
		}

		return $this->period;
	}

	/**
	 * getDuration() alias
	 *
	 * @see getDuration()
	 */
	public function getTime()
	{
		return $this->getDuration();
	}

	/**
	 * Stops the stopwatch and clears the time.
	 *
	 * @return self
	 */
	public function reset()
	{
		$this->period = 0;
		$this->startTime = 0;

		return $this;
	}
}
