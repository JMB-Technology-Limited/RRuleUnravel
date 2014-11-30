<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) 2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class RRuleUnraveling {

	/** @var  RRule */
	protected $rrule;

	function __construct($rrule)
	{
		$this->rrule = $rrule;
	}

	/**
	 * @return \JMBTechnologyLimited\RRuleUnravel\RRule
	 */
	public function getRrule()
	{
		return $this->rrule;
	}




}

