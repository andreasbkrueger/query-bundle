<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Operators\Comparison\Range as RangeOperator;

class Range extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        /**
         * @var RangeOperator $operator;
         */
        $operator = $this->getOperator();
        $fromHandler = $this->handlerFactory->getHandler($operator->getFromOperator());
        $toHandler = $this->handlerFactory->getHandler($operator->getToOperator());
        $testFrom = $value;
        $testTo = $value;

        if (is_array($value)) {
            $testFrom = min($value);
            $testTo = max($value);
        }

        return $fromHandler->doesMatch($testFrom) && $toHandler->doesMatch($testTo);
    }
}
