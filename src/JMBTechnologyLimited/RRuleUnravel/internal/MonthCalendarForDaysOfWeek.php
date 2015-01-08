<?php


namespace JMBTechnologyLimited\RRuleUnravel\internal;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */


class MonthCalendarForDaysOfWeek {

	protected $days = array(
		1=>'',
		2=>'',
		3=>'',
		4=>'',
		5=>'',
		6=>'',
		7=>'',
		8=>'',
		9=>'',
		10=>'',
		11=>'',
		12=>'',
		13=>'',
		14=>'',
		15=>'',
		16=>'',
		17=>'',
		18=>'',
		19=>'',
		20=>'',
		21=>'',
		22=>'',
		23=>'',
		24=>'',
		25=>'',
		26=>'',
		27=>'',
		28=>'',
		29=>'',
		30=>'',
		31=>'',
	);

	protected $start = array(
		1=>null,
		2=>null,
		3=>null,
		4=>null,
		5=>null,
		6=>null,
		7=>null,
		8=>null,
		9=>null,
		10=>null,
		11=>null,
		12=>null,
		13=>null,
		14=>null,
		15=>null,
		16=>null,
		17=>null,
		18=>null,
		19=>null,
		20=>null,
		21=>null,
		22=>null,
		23=>null,
		24=>null,
		25=>null,
		26=>null,
		27=>null,
		28=>null,
		29=>null,
		30=>null,
		31=>null,
	);

	protected $end = array(
		1=>null,
		2=>null,
		3=>null,
		4=>null,
		5=>null,
		6=>null,
		7=>null,
		8=>null,
		9=>null,
		10=>null,
		11=>null,
		12=>null,
		13=>null,
		14=>null,
		15=>null,
		16=>null,
		17=>null,
		18=>null,
		19=>null,
		20=>null,
		21=>null,
		22=>null,
		23=>null,
		24=>null,
		25=>null,
		26=>null,
		27=>null,
		28=>null,
		29=>null,
		30=>null,
		31=>null,
	);

	public function setDay($date, $dayOfWeek, $start, $end) {
		$this->days[$date] = $dayOfWeek;
		$this->start[$date] = clone $start;
		$this->end[$date] = clone $end;
	}

	public function getDay($date) {
		return $this->days[$date];
	}

	public function getStart($date) {
		return $this->start[$date];
	}

	public function getEnd($date) {
		return $this->end[$date];
	}

	public function getMaxDay() {
		return max(array_keys($this->days));
	}

	public function isDayNumber($date, $number) {
		if ($number == 0) {
			return true;
		}

		if ($number > 0) {
			$count = 0;
			for ($i = 1; $i <= $date; $i++) {
				if ($this->days[$i] == $this->days[$date]) {
					++$count;
				}
			}
			return $count == $number;
		} else {
			$count = 0;
			for ($i = 31; $i >= $date; $i--) {
				if ($this->days[$i] == $this->days[$date]) {
					--$count;
				}
			}
			return $count == $number;
		}
	}

}
