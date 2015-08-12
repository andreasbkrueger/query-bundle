<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;

class GreaterThan extends AbstractComparisonOperator
{
    protected function setName()
    {
        $this->name = Names::GREATER_THAN;
    }
}
