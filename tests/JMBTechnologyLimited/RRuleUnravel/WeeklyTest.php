<?php


namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class WeeklyTest extends \PHPUnit_Framework_TestCase {


	function test1set() {
		$timezone = new \DateTimeZone("Europe/London");
		$rrule = new RRule("FREQ=WEEKLY");
		$unraveler = new Unraveler($rrule, new \DateTime("2014-10-01 09:00:00", $timezone), new \DateTime("2014-10-01 17:00:00", $timezone), "Europe/London");
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 5);


		$this->assertEquals("2014-10-08T09:00:00+01:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-10-08T17:00:00+01:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2014-10-15T09:00:00+01:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2014-10-15T17:00:00+01:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2014-10-22T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2014-10-22T17:00:00+01:00", $results[2]->getEnd()->format("c"));

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[3]->getEnd()->format("c"));

	}


}



