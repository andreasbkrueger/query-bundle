<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class GreaterThanEqual extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        if (is_array($value)) {
            $value = max($value);
        }
        return $value >= $this->getOperator()->getValue();
    }
}
