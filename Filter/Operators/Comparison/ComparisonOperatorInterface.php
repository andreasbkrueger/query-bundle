<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\OperatorInterface;

interface ComparisonOperatorInterface extends OperatorInterface
{
    /**
     * @return string
     */
    public function getField();

    /**
     * @return mixed
     */
    public function getValue();
}
