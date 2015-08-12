<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;

class NotEqual extends AbstractComparisonOperator
{
    protected function setName()
    {
        $this->name = Names::NOT_EQUAL;
    }
}
