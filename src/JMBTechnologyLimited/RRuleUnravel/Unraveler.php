<?php

namespace JMBTechnologyLimited\RRuleUnravel;

use JMBTechnologyLimited\RRuleUnravel\internal\MonthCalendarForDaysOfWeek;
use JMBTechnologyLimited\RRuleUnravel\internal\ICalDataUnravelling;


/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class Unraveler {

	/** @var  ICalDataUnravelling */
	protected $icalDataUnravelling;

	protected $includeOriginalEvent = true;

	protected $results;

    protected $resultFilters = array();


    protected $resultsCountLimit = 100;

	function __construct(ICalData $ICalData)
	{
		$this->icalDataUnravelling = new ICalDataUnravelling($ICalData);
	}

	/**
	 * See ResultFilterInterface class for notes on this.
	 **/
    public function addResultFilter(ResultFilterInterface $resultFilterInterface) {
        $this->resultFilters[] = $resultFilterInterface;
    }

    /**
     * @param int $resultsCountLimit
     */
    public function setResultsCountLimit($resultsCountLimit)
    {
        $this->resultsCountLimit = $resultsCountLimit;
    }

	public function process()
	{

		$this->results = array();




		if ($this->icalDataUnravelling->getICalData()->getFreq() == "WEEKLY")
		{
			$this->stepBySimplePeriod("P".(7*$this->icalDataUnravelling->getICalData()->getInterval())."D");
		}
		else if ($this->icalDataUnravelling->getICalData()->getFreq() == "MONTHLY" && $this->icalDataUnravelling->getICalData()->isSetBymonthday())
		{
			$this->stepBySimplePeriod("P1M");
		}
		else if ($this->icalDataUnravelling->getICalData()->getFreq() == "MONTHLY" && $this->icalDataUnravelling->getICalData()->isSetByday())
		{
			$this->stepByDayMonthlyPeriod();
		}

	}

	protected function stepBySimplePeriod($intervalString) {
		$interval = new \DateInterval($intervalString);

		$start = clone $this->icalDataUnravelling->getICalData()->getStart();
		if ($start->getTimezone()->getName() != $end = clone $this->icalDataUnravelling->getICalData()->getTimezone()) {
			$start->setTimezone($this->icalDataUnravelling->getICalData()->getTimezone());
		}

		$end = clone $this->icalDataUnravelling->getICalData()->getEnd();
		if ($end->getTimezone()->getName() != $this->icalDataUnravelling->getICalData()->getTimezone()) {
			$end->setTimezone($this->icalDataUnravelling->getICalData()->getTimezone());
		}

		if ($this->includeOriginalEvent) {
			$this->results[] = new UnravelerResult(clone $start, clone $end);
		}

		$process = true;

		while($process) {

			$start->add($interval);
			$end->add($interval);

			$add = true;
			if (!$this->icalDataUnravelling->isCountLeft()) {
				$add = false;
				// can also stop processing now
				$process = false;
			} else if ($this->icalDataUnravelling->getICalData()->hasUntil() && $start > $this->icalDataUnravelling->getICalData()->getUntil()) {
				// it's inclusive, so we add this one but no mare
				$process = false;
			}

			if ($add)
			{
				$this->addResult($start, $end);
				$this->icalDataUnravelling->decreaseCount();
			}

			// This is a temporary stop for rules with no count, so they stop sometime.
			// Also > 2100 just as a safety to stop run away loops!
			// Need to do better!

			if (count($this->results) > $this->resultsCountLimit || $start->format("Y") > 2100)
			{
				$process = false;
			}

		}
	}


	public function stepByDayMonthlyPeriod() {
		$interval = new \DateInterval("P1D");


		$start = clone $this->icalDataUnravelling->getICalData()->getStart();
		if ($start->getTimezone()->getName() != $this->icalDataUnravelling->getICalData()->getTimezone()) {
			$start->setTimezone($this->icalDataUnravelling->getICalData()->getTimezone());
		}

		$end = clone $this->icalDataUnravelling->getICalData()->getEnd();
		if ($end->getTimezone()->getName() != $this->icalDataUnravelling->getICalData()->getTimezone()) {
			$end->setTimezone($this->icalDataUnravelling->getICalData()->getTimezone());
		}

		if ($this->includeOriginalEvent) {
			$this->addResult($start, $end);
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
							if ($this->icalDataUnravelling->getICalData()->isByDayMon() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDayMonNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Tue") {
							if ($this->icalDataUnravelling->getICalData()->isByDayTue() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDayTueNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Wed") {
							if ($this->icalDataUnravelling->getICalData()->isByDayWed() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDayWedNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Thu") {
							if ($this->icalDataUnravelling->getICalData()->isByDayThu() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDayThuNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Fri") {
							if ($this->icalDataUnravelling->getICalData()->isByDayFri() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDayFriNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Sat") {
							if ($this->icalDataUnravelling->getICalData()->isByDaySat() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDaySatNumber())) {
								$add = true;
							}
						} else if ($monthCalendar->getDay($i) == "Sun") {
							if ($this->icalDataUnravelling->getICalData()->isByDaySun() && $monthCalendar->isDayNumber($i, $this->icalDataUnravelling->getICalData()->getByDaySunNumber())) {
								$add = true;
							}
						}

						if ($add && $process) {

							$this->addResult($monthCalendar->getStart($i), $monthCalendar->getEnd($i));
							$this->icalDataUnravelling->decreaseCount();


							if (!$this->icalDataUnravelling->isCountLeft()) {
								// no more count, so stop processing
								$process = false;
							} else if ($this->icalDataUnravelling->getICalData()->hasUntil() && $start > $this->icalDataUnravelling->getICalData()->getUntil()) {
								// now after until date, no point carrying on.
							    $process = false;
							}
							// This is a temporary stop for rules with no count, so they stop sometime.
							// Need to do better!
							// Also > 2100 just as a safety to stop run away loops!
							if (count($this->results) > $this->resultsCountLimit || $start->format("Y") > 2100)
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

	protected function  addResult(\DateTime $start, \DateTime $end) {

        if (count($this->results) >= $this->resultsCountLimit) {
            return;
        }

		if ($this->icalDataUnravelling->getICalData()->hasUntil() && $start > $this->icalDataUnravelling->getICalData()->getUntil()) {
			return;
		}

		foreach($this->icalDataUnravelling->getICalData()->getExcluded() as $excluded) {
			if ($start->getTimezone()->getName() != $excluded['datetime']->getTimezone()->getName()) {
				// TODOD
			} else {
				if ($excluded['datetime']->format("c") == $start->format("c")) {
					return;
				}
			}
		}

        foreach($this->resultFilters as $resultFilter) {
            $result = $resultFilter->process($this->icalDataUnravelling->getICalData(), clone $start, clone $end);
            if (!$result->getProcess()) {
                return;
            }
        }

		$this->results[] = new UnravelerResult(clone $start, clone $end);
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


