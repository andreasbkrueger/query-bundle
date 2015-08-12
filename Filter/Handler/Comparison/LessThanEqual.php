<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class LessThanEqual extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        if (is_array($value)) {
            $value = min($value);
        }
        return $value <= $this->getOperator()->getValue();
    }
}
