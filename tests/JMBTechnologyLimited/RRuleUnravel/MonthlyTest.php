<?php


namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class MonthlyTest extends \PHPUnit_Framework_TestCase {


	function testDyDate1() {
		$rrule = new RRule("FREQ=MONTHLY;BYMONTHDAY=19");
		$this->assertTrue($rrule->isSetBymonthday());
		$unraveler = new Unraveler(
			$rrule,
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			"Europe/London");
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 2);


		$this->assertEquals("2014-12-19T08:00:00+00:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-12-19T08:00:00+00:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2015-01-19T08:00:00+00:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2015-01-19T08:00:00+00:00", $results[1]->getEnd()->format("c"));


	}


	function testDyDayOfWeek1() {
		$rrule = new RRule("FREQ=MONTHLY;BYDAY=3WE");
		$this->assertTrue($rrule->isSetByday());
		$this->assertFalse($rrule->isByDayMon());
		$this->assertFalse($rrule->isByDayTue());
		$this->assertTrue($rrule->isByDayWed());
		$this->assertEquals(3, $rrule->getByDayWedNumber());
		$this->assertFalse($rrule->isByDayThu());
		$this->assertFalse($rrule->isByDayFri());
		$this->assertFalse($rrule->isByDaySat());
		$this->assertFalse($rrule->isByDaySun());
		$unraveler = new Unraveler(
			$rrule,
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			"Europe/London");
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 2);


		$this->assertEquals("2014-12-17T08:00:00+00:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-12-17T08:00:00+00:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2015-01-21T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-01-21T08:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

	}


	function testDyDayOfWeek2() {
		$rrule = new RRule("FREQ=MONTHLY;BYDAY=-1WE");
		$this->assertTrue($rrule->isSetByday());
		$this->assertFalse($rrule->isByDayMon());
		$this->assertFalse($rrule->isByDayTue());
		$this->assertTrue($rrule->isByDayWed());
		$this->assertEquals(-1, $rrule->getByDayWedNumber());
		$this->assertFalse($rrule->isByDayThu());
		$this->assertFalse($rrule->isByDayFri());
		$this->assertFalse($rrule->isByDaySat());
		$this->assertFalse($rrule->isByDaySun());
		$unraveler = new Unraveler(
			$rrule,
			new \DateTime("2014-11-26 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-26 08:00:00", new \DateTimeZone("Europe/London")),
			"Europe/London");
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 2);


		$this->assertEquals("2014-12-31T08:00:00+00:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-12-31T08:00:00+00:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2015-01-28T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-01-28T08:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

	}




}
