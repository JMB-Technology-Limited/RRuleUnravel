<?php

namespace JMBTechnologyLimited\RRuleUnravel;



/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class ICalData {

	/** @var  \DateTime */
	protected $start;

	/** @var  \DateTime */
	protected $end;

	/** @var  \DateTimeZone */
	protected $timezone;

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

	protected $excluded = array();

	function __construct(\DateTime $start = null, \DateTime $end = null, $data = null, $timezone = null)
	{
		$this->start = $start;
		$this->end = $end;
		$this->timezone = is_string($timezone) ? new \DateTimeZone($timezone) : $timezone;
		if ($data && is_array($data))
		{
			$this->setRRuleByArray($data);
		}
		else if ($data && is_string($data))
		{
			$this->setRRuleByString($data);
		}
	}

	function setRRuleByString($data)
	{
		$array = array();
		foreach(explode(";", $data) as $keyAndValue) {
			list($key, $value) = explode("=", $keyAndValue,2);
			$array[$key] = $value;
		}
		$this->setRRuleByArray($array);
	}

	function setRRuleByArray($data)
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


	public function addExDateByString($exdtval, $exdtparam = "") {

		$timezone = new \DateTimeZone("UTC");

		foreach(explode(";", $exdtparam) as $exdtparamBit) {
			if (strpos( $exdtparamBit, "=") !== false) {
				list($k, $v) = explode("=", $exdtparamBit, 2);
				if ($k == "TZID") {
					$timezone = new \DateTimeZone($v);
				}
			}
		}

		foreach(explode(",",$exdtval) as $exdtvalBit) {
			if ($exdtvalBit) {
				$this->excluded[] = new \DateTime($exdtvalBit, $timezone);
			}
		}

	}

	/**
	 * @param \DateTime $end
	 */
	public function setEnd($end)
	{
		$this->end = $end;
	}

	/**
	 * @param \DateTime $start
	 */
	public function setStart($start)
	{
		$this->start = $start;
	}

	/**
	 * @param \DateTimeZone $timezone
	 */
	public function setTimezone($timezone)
	{
		$this->timezone = is_string($timezone) ? new \DateTimeZone($timezone) : $timezone;
	}




	/**
	 * @return \DateTime
	 */
	public function getEnd()
	{
		return $this->end;
	}

	/**
	 * @return \DateTime
	 */
	public function getStart()
	{
		return $this->start;
	}

	/**
	 * @return null
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

	/**
	 * @return array
	 */
	public function getExcluded()
	{
		return $this->excluded;
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


