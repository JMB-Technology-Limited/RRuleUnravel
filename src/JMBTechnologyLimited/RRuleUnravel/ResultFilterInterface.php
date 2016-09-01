<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * Result Filter - Filters can be used to decide if an event start/end recurrence should be in the output.
 *
 * Filters only make a decision about the one event they have been given, with no state about other start/end recurrences allowed.
 * This is because Filters can not guarantee in which order they will be called, or for which events.
 * So:
 *   -  If start before a certain date? Allowed! (See ResultFilterBeforeDateTime )
 *   -  We only want 5 events back, regardless of date? Not allowed as a filter! This requires knowing other state. Instead see Unraveler->setResultsCountLimit().
 *
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

interface ResultFilterInterface {

    /** @return ResultFilterResult Whether this start & end pass the filter. */
    public function process(ICalData $iCalData, \DateTime $start, \DateTime $end);

}