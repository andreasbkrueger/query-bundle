<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class Contain extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        /**
         * @var \ABK\QueryBundle\Filter\Operators\Comparison\Contain $operator ;
         */
        $operator = $this->getOperator();
        $operatorValue = $operator->getValue();

        if (empty($operatorValue)) {
            return false;
        }

        if (is_array($value)) {
            return $this->doesMatchInArray($value);
        }

        if ($operator->isCaseSensitive() === false) {
            $value = mb_strtolower($value);
            $operatorValue = mb_strtolower($operatorValue);
        }

        return (strpos($value, $operatorValue) !== false);
    }
}
