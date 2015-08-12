<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class LessThan extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        if (is_array($value)) {
            $value = min($value);
        }
        return $value < $this->getOperator()->getValue();
    }
}
