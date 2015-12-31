<?php


namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class RRuleSetByStringTest extends \PHPUnit_Framework_TestCase {


	function providerTest1() {
		return array(
			array('FREQ=YEARLY;BYDAY=WE', 'YEARLY', 'WE', -1),
			array('FREQ=YEARLY;BYDAY=WE;COUNT=5', 'YEARLY', 'WE', 5),
		);
	}

	/** @dataProvider providerTest1 */
	function test1set($in, $freq, $byday, $count) {
		$icaldata = new ICalData();
		$icaldata->setRRuleByString($in);
		$this->assertEquals($freq, $icaldata->getFreq());
		$this->assertEquals($byday, $icaldata->getByday());
		$this->assertEquals($count, $icaldata->getCount());
	}

	/** @dataProvider providerTest1 */
	function test1construct($in, $freq, $byday, $count) {
		$icaldata = new ICalData(null, null, $in);
		$this->assertEquals($freq, $icaldata->getFreq());
		$this->assertEquals($byday, $icaldata->getByday());
		$this->assertEquals($count, $icaldata->getCount());
	}

}



