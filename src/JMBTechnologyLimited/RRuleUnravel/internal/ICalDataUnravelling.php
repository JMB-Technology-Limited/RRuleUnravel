<?php

namespace JMBTechnologyLimited\RRuleUnravel\internal;

use JMBTechnologyLimited\RRuleUnravel\ICalData;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class ICalDataUnravelling {



	/** @var  integer */
	protected $count = -1;


	/** @var  ICalData */
	protected $icaldata;

	function __construct(ICalData $ICalData)
	{
		$this->icaldata = $ICalData;
		$this->count = $ICalData->getCount();
	}

	/**
	 * @return \JMBTechnologyLimited\RRuleUnravel\ICalData
	 */
	public function getICalData()
	{
		return $this->icaldata;
	}

	/**
	 * @return boolean
	 */
	public function isCountLeft()
	{
		// -1 indicates infinite and should return true
		return $this->count != 0;
	}

	public function decreaseCount()
	{
		if ($this->count > 0)
		{
			$this->count--;
		}
	}



}

