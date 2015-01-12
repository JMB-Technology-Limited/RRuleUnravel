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

	/**
	 * Whether we pass in or out in the local or UTC timezone should not matter, so let's test that
	 */
	function providerTest1() {
		return array(
			array(new \DateTime("2014-10-01 09:00:00", new \DateTimeZone("Europe/London")), new \DateTime("2014-10-01 17:00:00", new \DateTimeZone("Europe/London"))),
			array(new \DateTime("2014-10-01 08:00:00", new \DateTimeZone("UTC")), new \DateTime("2014-10-01 17:00:00", new \DateTimeZone("Europe/London"))),
			array(new \DateTime("2014-10-01 08:00:00", new \DateTimeZone("UTC")), new \DateTime("2014-10-01 16:00:00", new \DateTimeZone("UTC"))),
		);
	}

	/** @dataProvider providerTest1 */
	function test1($in, $out) {
		$icaldata = new ICalData($in, $out, "FREQ=WEEKLY", "Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 5);


		$this->assertEquals("2014-10-08T09:00:00+01:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-10-08T17:00:00+01:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2014-10-08T08:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-08T16:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-15T09:00:00+01:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2014-10-15T17:00:00+01:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2014-10-15T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-15T16:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-22T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2014-10-22T17:00:00+01:00", $results[2]->getEnd()->format("c"));

		$this->assertEquals("2014-10-22T08:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-22T16:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		// at this point the BST change happens

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[3]->getEnd()->format("c"));

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[3]->getEndInUTC()->format("c"));

	}

	/** @dataProvider providerTest1 */
	function test1withCount($in, $out) {
		$icaldata = new ICalData($in, $out, "FREQ=WEEKLY;COUNT=5",  "Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) == 5);

		$this->assertEquals("2014-10-08T09:00:00+01:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-10-08T17:00:00+01:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2014-10-08T08:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-08T16:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-15T09:00:00+01:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2014-10-15T17:00:00+01:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2014-10-15T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-15T16:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-22T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2014-10-22T17:00:00+01:00", $results[2]->getEnd()->format("c"));

		$this->assertEquals("2014-10-22T08:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-22T16:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		// at this point the BST change happens

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[3]->getEnd()->format("c"));

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[3]->getEndInUTC()->format("c"));
	}

	/** @dataProvider providerTest1 */
	function test1withOriginalEvent($in, $out) {
		$icaldata = new ICalData($in, $out,"FREQ=WEEKLY",  "Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(true);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 5);


		$this->assertEquals("2014-10-01T09:00:00+01:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-10-01T17:00:00+01:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2014-10-01T08:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-01T16:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-08T09:00:00+01:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2014-10-08T17:00:00+01:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2014-10-08T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-08T16:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-15T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2014-10-15T17:00:00+01:00", $results[2]->getEnd()->format("c"));

		$this->assertEquals("2014-10-15T08:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-15T16:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-22T09:00:00+01:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2014-10-22T17:00:00+01:00", $results[3]->getEnd()->format("c"));

		$this->assertEquals("2014-10-22T08:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-22T16:00:00+00:00", $results[3]->getEndInUTC()->format("c"));

		// at this point the BST change happens

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[4]->getStart()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[4]->getEnd()->format("c"));

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[4]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[4]->getEndInUTC()->format("c"));

	}

	/** @dataProvider providerTest1 */
	function test1withCountAndOriginalEvent($in, $out) {
		$icaldata = new ICalData($in, $out, "FREQ=WEEKLY;COUNT=5", "Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(true);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) == 6);

		$this->assertEquals("2014-10-01T09:00:00+01:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2014-10-01T17:00:00+01:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2014-10-01T08:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-01T16:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-08T09:00:00+01:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2014-10-08T17:00:00+01:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2014-10-08T08:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-08T16:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-15T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2014-10-15T17:00:00+01:00", $results[2]->getEnd()->format("c"));

		$this->assertEquals("2014-10-15T08:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-15T16:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		$this->assertEquals("2014-10-22T09:00:00+01:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2014-10-22T17:00:00+01:00", $results[3]->getEnd()->format("c"));

		$this->assertEquals("2014-10-22T08:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-22T16:00:00+00:00", $results[3]->getEndInUTC()->format("c"));

		// at this point the BST change happens

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[4]->getStart()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[4]->getEnd()->format("c"));

		$this->assertEquals("2014-10-29T09:00:00+00:00", $results[4]->getStartInUTC()->format("c"));
		$this->assertEquals("2014-10-29T17:00:00+00:00", $results[4]->getEndInUTC()->format("c"));
	}


	/**
	 * This came from Google Calendar.
	 * Sometimes they put in the BYDAY, sometimes they don't. No idea why,
	 */
	function testTwoWeeksPeriod() {
		$icaldata = new ICalData(
			new \DateTime("2015-02-12 09:00:00", new \DateTimeZone("UTC")),
			new \DateTime("2015-02-12 10:00:00", new \DateTimeZone("UTC")),
			"FREQ=WEEKLY;INTERVAL=2;BYDAY=TH",
			"Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 5);

		$this->assertEquals("2015-02-26T09:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-02-26T10:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-02-26T09:00:00+00:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2015-02-26T10:00:00+00:00", $results[0]->getEnd()->format("c"));


		$this->assertEquals("2015-03-12T09:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-03-12T10:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-03-12T09:00:00+00:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2015-03-12T10:00:00+00:00", $results[1]->getEnd()->format("c"));

		$this->assertEquals("2015-03-26T09:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-03-26T10:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-03-26T09:00:00+00:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2015-03-26T10:00:00+00:00", $results[2]->getEnd()->format("c"));

		// BST date shift

		$this->assertEquals("2015-04-09T08:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-04-09T09:00:00+00:00", $results[3]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-04-09T09:00:00+01:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2015-04-09T10:00:00+01:00", $results[3]->getEnd()->format("c"));


		$this->assertEquals("2015-04-23T08:00:00+00:00", $results[4]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-04-23T09:00:00+00:00", $results[4]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-04-23T09:00:00+01:00", $results[4]->getStart()->format("c"));
		$this->assertEquals("2015-04-23T10:00:00+01:00", $results[4]->getEnd()->format("c"));


	}



	function testTwoWeeksPeriodWithOneException() {
		$icaldata = new ICalData(
			new \DateTime("2015-02-12 09:00:00", new \DateTimeZone("UTC")),
			new \DateTime("2015-02-12 10:00:00", new \DateTimeZone("UTC")),
			"FREQ=WEEKLY;INTERVAL=2;BYDAY=TH",
			"Europe/London");
		$icaldata->setExDateByString("20150226T090000","TZID=Europe/London");
		$unraveler = new Unraveler($icaldata);
		$unraveler->setIncludeOriginalEvent(false);
		$unraveler->process();
		$results = $unraveler->getResults();

		$this->assertTrue(count($results) > 5);

		$this->assertEquals("2015-03-12T09:00:00+00:00", $results[0]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-03-12T10:00:00+00:00", $results[0]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-03-12T09:00:00+00:00", $results[0]->getStart()->format("c"));
		$this->assertEquals("2015-03-12T10:00:00+00:00", $results[0]->getEnd()->format("c"));

		$this->assertEquals("2015-03-26T09:00:00+00:00", $results[1]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-03-26T10:00:00+00:00", $results[1]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-03-26T09:00:00+00:00", $results[1]->getStart()->format("c"));
		$this->assertEquals("2015-03-26T10:00:00+00:00", $results[1]->getEnd()->format("c"));

		// BST date shift

		$this->assertEquals("2015-04-09T08:00:00+00:00", $results[2]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-04-09T09:00:00+00:00", $results[2]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-04-09T09:00:00+01:00", $results[2]->getStart()->format("c"));
		$this->assertEquals("2015-04-09T10:00:00+01:00", $results[2]->getEnd()->format("c"));


		$this->assertEquals("2015-04-23T08:00:00+00:00", $results[3]->getStartInUTC()->format("c"));
		$this->assertEquals("2015-04-23T09:00:00+00:00", $results[3]->getEndInUTC()->format("c"));

		$this->assertEquals("2015-04-23T09:00:00+01:00", $results[3]->getStart()->format("c"));
		$this->assertEquals("2015-04-23T10:00:00+01:00", $results[3]->getEnd()->format("c"));


	}

}



