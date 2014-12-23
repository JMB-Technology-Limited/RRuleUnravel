<?php

namespace JMBTechnologyLimited\RRuleUnravel;

use JMBTechnologyLimited\RRuleUnravel\internal\MonthCalendarForDaysOfWeek;
use JMBTechnologyLimited\RRuleUnravel\internal\RRuleUnravelling;


/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class Unraveler {

	/** @var  RRuleUnravelling */
	protected $rruleUnravelling;

	/** @var  \DateTime */
	protected $start;

	/** @var  \DateTime */
	protected $end;

	protected $timezone;

	protected $includeOriginalEvent = true;

	protected $results;

	function __construct(RRule $rrule, \DateTime $start, \DateTime $end, $timezone='UTC')
	{
		$this->rruleUnravelling = new RRuleUnravelling($rrule);
		$this->start = $start;
		$this->end = $end;
		$this->timezone = $timezone;
	}


	public function process()
	{

		$this->results = array();




		if ($this->rruleUnravelling->getRrule()->getFreq() == "WEEKLY")
		{
			$this->stepBySimplePeriod("P7D");
		}
		else if ($this->rruleUnravelling->getRrule()->getFreq() == "MONTHLY" && $this->rruleUnravelling->getRrule()->isSetBymonthday())
		{
			$this->stepBySimplePeriod("P1M");
		}
		else if ($this->rruleUnravelling->getRrule()->getFreq() == "MONTHLY" && $this->rruleUnravelling->getRrule()->isSetByday())
		{
			$this->stepByDayMonthlyPeriod();
		}

	}

	protected function stepBySimplePeriod($intervalString) {
		$interval = new \DateInterval($intervalString);

		$start = clone $this->start;
		if ($start->getTimezone()->getName() != $this->timezone) {
			$start->setTimezone(new \DateTimeZone($this->timezone));
		}

		$end = clone $this->end;
		if ($end->getTimezone()->getName() != $this->timezone) {
			$end->setTimezone(new \DateTimeZone($this->timezone));
		}

		if ($this->includeOriginalEvent) {
			$this->results[] = new UnravelerResult(clone $start, clone $end);
		}

		$process = true;

		while($process) {

			$start->add($interval);
			$end->add($interval);

			$add = true;
			if (!$this->rruleUnravelling->isCountLeft()) {
				$add = false;
				// can also stop processing now
				$process = false;
			}

			if ($add)
			{
				$this->results[] = new UnravelerResult(clone $start, clone $end);
				$this->rruleUnravelling->decreaseCount();
			}

			// This is a temporary stop for rules with no count, so they stop sometime.
			// Need to do better!
			if (count($this->results) > 100)
			{
				$process = false;
			}

		}
	}


	public function stepByDayMonthlyPeriod() {
		$interval = new \DateInterval("P1D");


		$start = clone $this->start;
		if ($start->getTimezone()->getName() != $this->timezone) {
			$start->setTimezone(new \DateTimeZone($this->timezone));
		}

		$end = clone $this->end;
		if ($end->getTimezone()->getName() != $this->timezone) {
			$end->setTimezone(new \DateTimeZone($this->timezone));
		}

		if ($this->includeOriginalEvent) {
			$this->results[] = new UnravelerResult(clone $start, clone $end);
		}

		$process = true;
		$currentMonth = $start->format('m');

		$monthCalendar = null;

		while($process) {

			$start->add($interval);
			$end->add($interval);


			if ($currentMonth != $start->format('m')) {

				if ($monthCalendar) {

					for ($i = 1; $i <= $monthCalendar->getMaxDay(); $i++) {
						$add = false;

						if ($monthCalendar->getDay($i) == "Mon") {
							if ($this->rruleUnravelling->getRrule()->isByDayMon() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDayMonNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Tue") {
							if ($this->rruleUnravelling->getRrule()->isByDayTue() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDayTueNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Wed") {
							if ($this->rruleUnravelling->getRrule()->isByDayWed() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDayWedNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Thu") {
							if ($this->rruleUnravelling->getRrule()->isByDayThu() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDayThuNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Fri") {
							if ($this->rruleUnravelling->getRrule()->isByDayFri() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDayFriNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Sat") {
							if ($this->rruleUnravelling->getRrule()->isByDaySat() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDaySatNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Sun") {
							if ($this->rruleUnravelling->getRrule()->isByDaySun() && $monthCalendar->isDayNumber($i, $this->rruleUnravelling->getRrule()->getByDaySunNumber())) {
								$add = true;
							}
						}

						if ($add && $process) {

							$this->results[] = new UnravelerResult($monthCalendar->getStart($i), $monthCalendar->getEnd($i));
							$this->rruleUnravelling->decreaseCount();


							if (!$this->rruleUnravelling->isCountLeft()) {
								$add = false;
								// can also stop processing now
								$process = false;
							}
							// This is a temporary stop for rules with no count, so they stop sometime.
							// Need to do better!
							if (count($this->results) > 100)
							{
								$process = false;
							}

						}

					}

				}

				$monthCalendar = new MonthCalendarForDaysOfWeek();
				$monthCalendar->setDay($start->format("j"), $start->format("D"), $start, $end);
				$currentMonth = $start->format('m');

			} else {

				if ($monthCalendar) {
					$monthCalendar->setDay($start->format("j"), $start->format("D"), $start, $end);
				}
			}


		}




	}




	/**
	 * @param boolean $includeOriginalEvent
	 */
	public function setIncludeOriginalEvent($includeOriginalEvent)
	{
		$this->includeOriginalEvent = $includeOriginalEvent;
	}

	/**
	 * @return boolean
	 */
	public function getIncludeOriginalEvent()
	{
		return $this->includeOriginalEvent;
	}



	public function getResults()
	{
		return $this->results;
	}

}


