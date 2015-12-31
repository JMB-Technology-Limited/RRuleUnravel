<?php


namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class MonthlyTest extends \PHPUnit_Framework_TestCase {


	function testDyDate1() {
		$icalData = new ICalData(
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			"FREQ=MONTHLY;BYMONTHDAY=19",
				new \DateTimeZone("Europe/London"));
		$this->assertTrue($icalData->isSetBymonthday());
		$unraveler = new Unraveler($icalData);
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
		$icalData = new ICalData(
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
			"FREQ=MONTHLY;BYDAY=3WE",
			"Europe/London");
		$this->assertTrue($icalData->isSetByday());
		$this->assertFalse($icalData->isByDayMon());
		$this->assertFalse($icalData->isByDayTue());
		$this->assertTrue($icalData->isByDayWed());
		$this->assertEquals(3, $icalData->getByDayWedNumber());
		$this->assertFalse($icalData->isByDayThu());
		$this->assertFalse($icalData->isByDayFri());
		$this->assertFalse($icalData->isByDaySat());
		$this->assertFalse($icalData->isByDaySun());
		$unraveler = new Unraveler($icalData);
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
		$icalData = new ICalData(
			new \DateTime("2014-11-26 08:00:00", new \DateTimeZone("Europe/London")),
			new \DateTime("2014-11-26 08:00:00", new \DateTimeZone("Europe/London")),
			"FREQ=MONTHLY;BYDAY=-1WE",
			"Europe/London");
		$this->assertTrue($icalData->isSetByday());
		$this->assertFalse($icalData->isByDayMon());
		$this->assertFalse($icalData->isByDayTue());
		$this->assertTrue($icalData->isByDayWed());
		$this->assertEquals(-1, $icalData->getByDayWedNumber());
		$this->assertFalse($icalData->isByDayThu());
		$this->assertFalse($icalData->isByDayFri());
		$this->assertFalse($icalData->isByDaySat());
		$this->assertFalse($icalData->isByDaySun());
		$unraveler = new Unraveler($icalData);
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
