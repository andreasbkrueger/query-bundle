<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\HandlerInterface as BaseHandlerInterface;
use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;

interface HandlerInterface extends BaseHandlerInterface
{
    /**
     * @param ComparisonOperatorInterface $operator
     */
    public function setOperator(ComparisonOperatorInterface $operator);
}
