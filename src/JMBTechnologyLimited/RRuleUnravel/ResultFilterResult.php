<?php

namespace JMBTechnologyLimited\RRuleUnravel;

/**
 *
 * @link https://github.com/JMB-Technology-Limited/RRuleUnravel
 * @license https://raw.github.com/JMB-Technology-Limited/RRuleUnravel/master/LICENSE.txt 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */

class ResultFilterResult {

    protected $process;

    function __construct($process)
    {
        $this->process = $process;
    }

    /**
     * @return mixed
     */
    public function getProcess()
    {
        return $this->process;
    }


}