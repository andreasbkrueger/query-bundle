<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

class NotIdentical extends AbstractHandler implements HandlerInterface
{
    public function doesMatch($value)
    {
        $foundMatch = false;
        if (is_array($value)) {
            foreach ($value as $item) {
                if (!$this->doesMatch($item)) {
                    $foundMatch = true;
                };
            }
        }
        return $foundMatch === false && $this->getOperator()->getValue() !== $value;
    }
}
