<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/ParseDateTimeRangeString
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2013-2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class RRule {


	protected $freq;

	protected $byday;

	function __construct($data = null)
	{
		if ($data && is_array($data))
		{
			$this->setByArray($data);
		}
		else if ($data && is_string($data))
		{
			$this->setByString($data);
		}
	}

	function setByString($data)
	{
		$array = array();
		foreach(explode(";", $data) as $keyAndValue) {
			list($key, $value) = explode("=", $keyAndValue,2);
			$array[$key] = $value;
		}
		$this->setByArray($array);
	}

	function setByArray($data)
	{
		foreach($data as $key=>$value)
		{
			if ($key == 'FREQ')
			{
				$this->freq = $value;
			}
			else if ($key == 'BYDAY')
			{
				$this->byday = $value;
			}
		}

	}

	/**
	 * @param mixed $byday
	 */
	public function setByday($byday)
	{
		$this->byday = $byday;
	}

	/**
	 * @return mixed
	 */
	public function getByday()
	{
		return $this->byday;
	}

	/**
	 * @param mixed $freq
	 */
	public function setFreq($freq)
	{
		$this->freq = $freq;
	}

	/**
	 * @return mixed
	 */
	public function getFreq()
	{
		return $this->freq;
	}




}