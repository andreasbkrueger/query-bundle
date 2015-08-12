<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class Identical extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        if (is_array($value)) {
            return $this->doesMatchInArray($value);
        }
        return $this->getOperator()->getValue() === $value;
    }
}
