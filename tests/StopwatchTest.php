<?php
/**
 * PHP Unit test for Stopwatch class
 *
 * @package SugiPHP.Profiler
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Profiler;

class StopwatchTest extends \PHPUnit_Framework_TestCase
{
	public function testStartStopReturnsStopwatch()
	{
		$stw = new Stopwatch();
		$this->assertInstanceOf("SugiPHP\Profiler\Stopwatch", $stw->start());
		$this->assertInstanceOf("SugiPHP\Profiler\Stopwatch", $stw->stop());
	}

	public function testDurationNotStarted()
	{
		$stw = new Stopwatch();
		$this->assertSame(0, $stw->getDuration());
	}

	public function testDurationWhileNotStopped()
	{
		$stw = new Stopwatch();
		$stw->start();
		$this->assertGreaterThan(0, $stw->getDuration());
	}

	public function testDurationAfterStop()
	{
		$stw = new Stopwatch();
		$stw->start()->stop();
		$duration1 = $stw->getDuration();
		$this->assertGreaterThan(0, $duration1);
		$stw->start()->stop();
		$duration2 = $stw->getDuration();
		$this->assertGreaterThan($duration1, $duration2);
	}

	public function testIsRunning()
	{
		$stw = new Stopwatch();
		$this->assertFalse($stw->isRunning());
		$stw->getDuration();
		$this->assertFalse($stw->isRunning());
		$stw->start();
		$this->assertTrue($stw->isRunning());
		// still running
		$stw->getDuration();
		$this->assertTrue($stw->isRunning());
		$stw->stop();
		$this->assertFalse($stw->isRunning());
		$stw->start();
		$this->assertTrue($stw->isRunning());
	}

	public function testReset()
	{
		$stw = new Stopwatch();
		$stw->start();
		$stw->reset();
		$this->assertFalse($stw->isRunning());
		$this->assertSame(0, $stw->getDuration());
	}

	/**
	 * An exception is thrown trying to stop not started stopwatch.
	 *
	 * @expectedException SugiPHP\Profiler\Exception
	 */
	public function testStopWithoutStart()
	{
		$stw = new Stopwatch();
		$stw->stop();
	}

	/**
	 * An exception is thrown trying to start stopwatch without stopping it.
	 *
	 * @expectedException SugiPHP\Profiler\Exception
	 */
	public function testDoubleStart()
	{
		$stw = new Stopwatch();
		$stw->start();
		$stw->start();
	}
}
