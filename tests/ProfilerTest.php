<?php
/**
 * @package    SugiPHP.Profiler
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Profiler;

class ProfilerTest extends \PHPUnit_Framework_TestCase
{
	public function testActiveOnCreation()
	{
		$profiler = new Profiler();
		$this->assertTrue($profiler->isActive());
	}

	public function testProfilesAreEmptyOnCreation()
	{
		$profiler = new Profiler();
		$this->assertEmpty($profiler->getProfiles());
		$this->assertSame(0, count($profiler->getProfiles()));
	}

	public function testSetActive()
	{
		$profiler = new Profiler();
		$profiler->setActive(false);
		$this->assertFalse($profiler->isActive());
		$profiler->setActive(true);
		$this->assertTrue($profiler->isActive());
	}

	public function testProfilesAreEmptyWhenNotActive()
	{
		$profiler = new Profiler();
		$profiler->setActive(false);
		$profiler->addProfile(1);
		$this->assertEmpty($profiler->getProfiles());
		$this->assertSame(0, count($profiler->getProfiles()));
	}

	public function testAddProfile()
	{
		$profiler = new Profiler();
		$profiler->addProfile(1);
		$profiles = $profiler->getProfiles();
		$this->assertSame(1, count($profiles));
		// stop profiler
		$profiler->setActive(false);
		$profiler->addProfile(2);
		$profiles = $profiler->getProfiles();
		$this->assertSame(1, count($profiles));
		// start profiler again
		$profiler->setActive(true);
		$profiler->addProfile(3, array("my" => "custom", "parameters"));
		$profiles = $profiler->getProfiles();
		$this->assertSame(2, count($profiles));
		$profiler->addProfile(4, array("trace" => "custom trace", "duration" => 100, "foo" => "bar"));
		$profiles = $profiler->getProfiles();
		$this->assertSame(3, count($profiles));

		$this->assertSame(1, $profiles[0]["duration"]);
		$this->assertSame(3, $profiles[1]["duration"]);
		$this->assertArrayHasKey("trace", $profiles[0]);
		$this->assertArrayHasKey("trace", $profiles[1]);
		$this->assertArrayHasKey("my", $profiles[1]);
		$this->assertSame("custom", $profiles[1]["my"]);
		$this->assertTrue(in_array("parameters", $profiles[1]));

		// custom parameters WILL NOT override "duration" and debug "trace" params
		$this->assertNotEquals("custom trace", $profiles[2]["trace"]);
		$this->assertSame(4, $profiles[2]["duration"]);
		// all other params are being saved
		$this->assertSame("bar", $profiles[2]["foo"]);

		// reset
		$profiler->resetProfiles();
		$profiles = $profiler->getProfiles();
		$this->assertSame(0, count($profiles));
	}
}
