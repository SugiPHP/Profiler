<?php
/**
 * @package SugiPHP.Profiler
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Profiler;

/**
 * Profiler class
 */
class Profiler
{
	/**
	 * Whether a profiler will store profiles or not.
	 *
	 * @var boolean
	 */
	protected $active = true;

	/**
	 * Saved profiles.
	 *
	 * @var array
	 */
	protected $profiles = array();

	/**
     * Turns the profiler on and off.
     *
     * @param bool $active TRUE to turn profiler on, FALSE to turn it off.
	 */
	public function setActive($active)
	{
		$this->active = (bool) $active;
	}

	/**
	 * Is the profiler saving or not.
	 *
	 * @return boolean TRUE if the profiler saves profiles or FALSE if not.
	 */
	public function isActive()
	{
		return $this->active;
	}

	/**
	 * Adding a profile entry to the queue only if the profiler is set to active.
	 *
	 * @param  float $duration
	 * @param  array $params Optional. Custom parameters to be saved along with default "duration" and debug "trace".
	 * @return array|FALSE Returns FALSE if the profiler is not active
	 */
	public function addProfile($duration, array $params = array())
	{
		if (!$this->isActive()) {
			return false;
		}

		$e = new \Exception();
		$profile = array_merge($params, array("duration" => $duration, "trace" => $e->getTraceAsString()));
		$this->profiles[] = $profile;

		return $profile;
	}

	/**
	 * Returns all profile entries.
	 *
	 * @return array
	 */
	public function getProfiles()
	{
		return $this->profiles;
	}

	/**
	 * Clears stored profile entries.
	 */
	public function resetProfiles()
	{
		$this->profiles = array();
	}
}
