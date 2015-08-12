<?php

namespace ABK\QueryBundle\Filter\Operators\Structure;

use ABK\QueryBundle\Filter\Filter;
use ABK\QueryBundle\Filter\Operators\Names;

class NestedFilter extends AbstractStructureOperator
{
    /**
     * @var Filter
     */
    protected $filter;

    protected function setName()
    {
        $this->name = Names::NESTED_FILTER;
    }

    public function __construct(Filter $filter)
    {
        $this->setFilter($filter);
        parent::__construct();
    }

    protected function setFilter(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
