<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Logical;

use ABK\QueryBundle\Filter\Operators\AbstractOperator;
use ABK\QueryBundle\Filter\Operators\Types;

abstract class AbstractLogicalOperator extends AbstractOperator
{
    protected function setType()
    {
        $this->type = Types::LOGICAL;
    }
}
