<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class RRule {


	protected $freq;

	protected $byday;


	/** @var bool */
	protected $byDayMon = false;
	/** @var int */
	protected $byDayMonNumber = 0;
	/** @var bool */
	protected $byDayTue = false;
	/** @var int */
	protected $byDayTueNumber = 0;
	/** @var bool */
	protected $byDayWed = false;
	/** @var int */
	protected $byDayWedNumber = 0;
	/** @var bool */
	protected $byDayThu = false;
	/** @var int */
	protected $byDayThuNumber = 0;
	/** @var bool */
	protected $byDayFri = false;
	/** @var int */
	protected $byDayFriNumber = 0;
	/** @var bool */
	protected $byDaySat = false;
	/** @var int */
	protected $byDaySatNumber = 0;
	/** @var bool */
	protected $byDaySun = false;
	/** @var int */
	protected $byDaySunNumber = 0;

	/** @var  integer */
	protected $count = -1;

	protected $bymonthday;

	protected $interval = 1;


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
				foreach(explode(",",$value) as $bit) {
					$day = substr(trim($bit), -2);
					$number = strlen(trim($bit)) > 2 ? intval( substr(trim($bit), 0 , -2)) : 0;
					if ($day == "MO") {
						$this->byDayMon = true;
						$this->byDayMonNumber = $number;
					} else if ($day == "TU") {
						$this->byDayTue = true;
						$this->byDayTueNumber = $number;
					} else if ($day == "WE") {
						$this->byDayWed = true;
						$this->byDayWedNumber = $number;
					} else if ($day == "TH") {
						$this->byDayThu = true;
						$this->byDayThuNumber = $number;
					} else if ($day == "FR") {
						$this->byDayFri = true;
						$this->byDayFriNumber = $number;
					} else if ($day == "SA") {
						$this->byDaySat = true;
						$this->byDaySatNumber = $number;
					} else if ($day == "SU") {
						$this->byDaySun = true;
						$this->byDaySunNumber = $number;
					}
				}
			}
			else if ($key == 'COUNT')
			{
				$this->count = $value;
			}
			else if ($key == 'INTERVAL')
			{
				$this->interval = intval($value);
			}
			else if ($key == 'BYMONTHDAY')
			{
				$this->bymonthday = $value;
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
	 * @return boolean
	 */
	public function isSetByday()
	{
		return (boolean)$this->byday;
	}

	/**
	 * @return boolean
	 */
	public function isByDayFri()
	{
		return $this->byDayFri;
	}

	/**
	 * @return int
	 */
	public function getByDayFriNumber()
	{
		return $this->byDayFriNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDayMon()
	{
		return $this->byDayMon;
	}

	/**
	 * @return int
	 */
	public function getByDayMonNumber()
	{
		return $this->byDayMonNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDaySat()
	{
		return $this->byDaySat;
	}

	/**
	 * @return int
	 */
	public function getByDaySatNumber()
	{
		return $this->byDaySatNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDaySun()
	{
		return $this->byDaySun;
	}

	/**
	 * @return int
	 */
	public function getByDaySunNumber()
	{
		return $this->byDaySunNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDayThu()
	{
		return $this->byDayThu;
	}

	/**
	 * @return int
	 */
	public function getByDayThuNumber()
	{
		return $this->byDayThuNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDayTue()
	{
		return $this->byDayTue;
	}

	/**
	 * @return int
	 */
	public function getByDayTueNumber()
	{
		return $this->byDayTueNumber;
	}

	/**
	 * @return boolean
	 */
	public function isByDayWed()
	{
		return $this->byDayWed;
	}

	/**
	 * @return int
	 */
	public function getByDayWedNumber()
	{
		return $this->byDayWedNumber;
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

	/**
	 * @param int $count
	 */
	public function setCount($count)
	{
		$this->count = $count;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * @param mixed $bymonthday
	 */
	public function setBymonthday($bymonthday)
	{
		$this->bymonthday = $bymonthday;
	}

	/**
	 * @return mixed
	 */
	public function getBymonthday()
	{
		return $this->bymonthday;
	}

	/**
	 * @return boolean
	 */
	public function isSetBymonthday()
	{
		return (boolean)$this->bymonthday;
	}

	/**
	 * @return int
	 */
	public function getInterval()
	{
		return $this->interval;
	}



}


