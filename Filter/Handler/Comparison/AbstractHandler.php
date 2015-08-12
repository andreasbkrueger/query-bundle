<?php
namespace ABK\QueryBundle\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Factory;
use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected $operator;
    protected $handlerFactory;

    public function __construct(ComparisonOperatorInterface $operator, Factory $handlerFactory)
    {
        $this->setOperator($operator);
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * @param ComparisonOperatorInterface $operator
     */
    public function setOperator(ComparisonOperatorInterface $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return ComparisonOperatorInterface
     */
    public function getOperator()
    {
        return $this->operator;
    }

    protected function doesMatchInArray(array $data)
    {
        foreach ($data as $item) {
            if ($this->doesMatch($item)) {
                return true;
            };
        }
        return false;
    }
}
