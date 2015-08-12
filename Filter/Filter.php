<?php

namespace ABK\QueryBundle\Filter;

use ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException;
use ABK\QueryBundle\Filter\Operators\OperatorInterface;

/**
 * Class Filter
 * @package ABK\QueryBundle\Filter
 */
class Filter
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var OperatorInterface[]
     */
    protected $operators = array();

    public function __construct()
    {
        foreach (func_get_args() as $arg) {
            if ($arg instanceof OperatorInterface) {
                $this->addOperator($arg);
            } else {
                throw new InvalidArgumentException('The given argument is not a valid operator.');
            }
        }
    }

    /**
     * @param OperatorInterface $operator
     */
    public function addOperator(OperatorInterface $operator)
    {
        $this->operators[] = $operator;
        $operator->setParent($this);
    }

    /**
     * @return OperatorInterface[] array
     */
    public function getOperators()
    {
        return $this->operators;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int) $limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int) $offset;
    }
}
