<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
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

	protected $results;

	function __construct(RRule $rrule, \DateTime $start, \DateTime $end, $timezone='UTC')
	{
		$this->rruleUnraveling = new RRuleUnraveling($rrule);
		$this->start = $start;
		$this->end = $end;
		$this->timezone = $timezone;
	}


	public function process()
	{

		$this->results = array();

		$start = clone $this->start;
		$end = clone $this->end;

		$intervalString = "";
		if ($this->rruleUnraveling->getRrule()->getFreq() == "WEEKLY")
		{
			$intervalString = "P7D";
		}


		if ($intervalString)
		{
			$interval = new \DateInterval($intervalString);

			$process = true;

			while($process) {

				$start->add($interval);
				$end->add($interval);

				$this->results[] = new UnravelerResult(clone $start, clone $end);


				$process = (count($this->results) < 100);

			}


		}

	}

	public function getResults()
	{
		return $this->results;
	}

}