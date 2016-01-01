<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class ResultFilterAfterDateTime implements ResultFilterInterface{

    protected $datetime;

    function __construct($datetime)
    {
        $this->datetime = $datetime;
    }

    public function process(ICalData $iCalData, \DateTime $start, \DateTime $end)
    {
        return new ResultFilterResult($end->getTimestamp() > $this->datetime->getTimestamp());
    }

}