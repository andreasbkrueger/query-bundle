<?php
namespace ABK\QueryBundle\Builder;

use ABK\QueryBundle\Filter\Filter;
use ABK\QueryBundle\Filter\FilterCollection;
use ABK\QueryBundle\Filter\Operators\Comparison\Equal;
use ABK\QueryBundle\Filter\Operators\Logical\LogicalAnd;
use ABK\QueryBundle\Filter\Operators\Logical\LogicalOr;
use ABK\QueryBundle\Filter\Operators\Structure\NestedFilter;

class Builder
{
    protected $query = null;

    /**
     * @var FilterCollection
     */
    protected $filters;

    /**
     * @var Filter|NestedFilter|null
     */
    protected $currentFilter = null;

    public function __construct()
    {
        $this->filters = new FilterCollection();
    }

    /**
     * Opens the query section of this query set. There can only be one
     * specific query section. Sub-Queries are still possible inside this section.
     * It need to be closed. @see $this->end().
     * @param mixed $queryId
     * @return $this
     */
    public function query($queryId = null)
    {
        $this->addFilter($queryId, true);
        return $this;
    }

    /**
     * Opens a new filter sections to the query set. There can be unlimited filters added. Also sub-queries are
     * possible inside this section.
     * It need to be closed. @see $this->end().
     * @param mixed $filterId
     * @return $this
     */
    public function filter($filterId = null)
    {
        $this->addFilter($filterId);
        return $this;
    }

    protected function addFilter($filterId, $asQuery = false)
    {
        $filter = new Filter();

        if ($filterId === null) {
            $filterId = uniqid();
        }

        $filter->setName($filterId);

        if ($this->currentFilter === null) {
            $this->currentFilter = $filter;
            if ($asQuery) {
                $this->query = $filter;
            } else {
                $this->filters->add($filter);
            }
        } else {
            $nestedFilter = new NestedFilter($filter);
            if ($this->currentFilter instanceof Filter) {
                $this->currentFilter->addOperator($nestedFilter);
            } elseif ($this->currentFilter instanceof NestedFilter) {
                $this->currentFilter->getFilter()->addOperator($nestedFilter);
            }
            $this->currentFilter = $nestedFilter;
        }
    }

    /**
     * @param $filterId
     * @param array $searchTarget
     * @return bool|Filter
     */
    public function findFilterById($filterId, array $searchTarget = null)
    {
        if ($searchTarget === null) {
            $searchTarget = $this->filters;
        }

        foreach ($searchTarget as $item) {
            if ($item instanceof NestedFilter) {
                $filter = $item->getFilter();
            } elseif ($item instanceof Filter) {
                $filter = $item;
            } else {
                continue;
            }

            if ($filter->getName() === $filterId) {
                return $filter;
            } else {
                $matchedFilter = $this->findFilterById($filterId, $filter->getOperators());
                if ($matchedFilter) {
                    return $matchedFilter;
                }
            }
        }
        return false;
    }

    public function isEqual($field, $value)
    {
        $this->getCurrentFilter()->addOperator(new Equal($field, $value));
        return $this;
    }

    public function logicalAnd()
    {
        $this->getCurrentFilter()->addOperator(new LogicalAnd());
        return $this;
    }

    public function logicalOr()
    {
        $this->getCurrentFilter()->addOperator(new LogicalOr());
        return $this;
    }

    public function end()
    {
        if ($this->currentFilter instanceof Filter) {
            $this->currentFilter = null;
        } elseif ($this->currentFilter instanceof NestedFilter) {
            $this->currentFilter = $this->currentFilter->getParent();
        }
        return $this;
    }

    /**
     * @return Filter|null
     */
    protected function getCurrentFilter()
    {
        if ($this->currentFilter instanceof Filter) {
            return $this->currentFilter;
        } elseif ($this->currentFilter instanceof NestedFilter) {
            return $this->currentFilter->getFilter();
        } else {
            return null;
        }
    }
}
