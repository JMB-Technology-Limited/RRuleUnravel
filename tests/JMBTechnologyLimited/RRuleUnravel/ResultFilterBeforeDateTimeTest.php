<?php


namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class ResultFilterBeforeDateTimeTest extends \PHPUnit_Framework_TestCase {




    function test1() {
        $icalData = new ICalData(
            new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
            new \DateTime("2014-11-19 08:00:00", new \DateTimeZone("Europe/London")),
            "FREQ=MONTHLY;BYMONTHDAY=19",
            new \DateTimeZone("Europe/London"));
        $this->assertTrue($icalData->isSetBymonthday());
        $unraveler = new Unraveler($icalData);
        $unraveler->setIncludeOriginalEvent(false);
        $unraveler->addResultFilter(new ResultFilterBeforeDateTime(new \DateTime('2015-01-01 00:00:00', new \DateTimeZone("Europe/London"))));
        $unraveler->process();
        $results = $unraveler->getResults();

        $this->assertTrue(count($results) == 1);

        $this->assertEquals("2014-12-19T08:00:00+00:00", $results[0]->getStart()->format("c"));
        $this->assertEquals("2014-12-19T08:00:00+00:00", $results[0]->getEnd()->format("c"));


    }


}
