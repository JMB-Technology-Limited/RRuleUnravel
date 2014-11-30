<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/ParseDateTimeRangeString
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2013-2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class Unraveler {

	/** @var  RRuleUnraveling */
	protected $rruleUnraveling;

	/** @var  \DateTime */
	protected $start;

	/** @var  \DateTime */
	protected $end;

	protected $timezone;

	function __construct(RRule $rrule, \DateTime $start, \DateTime $end, $timezone='UTC')
	{
		$this->rruleUnraveling = new RRuleUnraveling($rrule);
		$this->start = $start;
		$this->end = $end;
		$this->timezone = $timezone;
	}


	public function process()
	{

	}

	public function getResults()
	{

	}

}