<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Filter\Operators;

use ABK\QueryBundle\Filter\Filter;

abstract class AbstractOperator implements OperatorInterface
{
    protected $type;
    protected $name;

    /**
     * @var Filter
     */
    protected $parent;

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->setType();
        $this->setName();
    }

    public function setParent(Filter $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Filter
     */
    public function getParent()
    {
        return $this->parent;
    }

    abstract protected function setType();
    abstract protected function setName();
}
