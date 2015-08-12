<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;

class LessThan extends AbstractComparisonOperator
{
    protected function setName()
    {
        $this->name = Names::LESS_THAN;
    }
}
