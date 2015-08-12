<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;

class Identical extends AbstractComparisonOperator
{
    protected function setName()
    {
        $this->name = Names::IDENTICAL;
    }
}
