<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Logical;

use ABK\QueryBundle\Filter\Operators\Names;

class LogicalOr extends AbstractLogicalOperator
{
    protected function setName()
    {
        $this->name = Names::LOGICAL_OR;
    }
}
