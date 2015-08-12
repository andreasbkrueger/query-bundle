<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class Equal extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        if (is_array($value)) {
            return $this->doesMatchInArray($value);
        }
        return $this->getOperator()->getValue() == $value;
    }
}
