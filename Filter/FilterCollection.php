<?php
namespace ABK\QueryBundle\Filter;

class FilterCollection implements \Iterator, \Countable
{

    protected $filterCollection = array();

    /**
     * @param Filter $filter
     */
    public function add(Filter $filter)
    {
        $this->filterCollection[] = $filter;
    }

    public function rewind()
    {
        reset($this->filterCollection);
    }

    /**
     * @return Filter
     */
    public function current()
    {
        $var = current($this->filterCollection);
        return $var;
    }

    public function key()
    {
        $var = key($this->filterCollection);
        return $var;
    }

    public function next()
    {
        $var = next($this->filterCollection);
        return $var;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->filterCollection);
        return ($key !== null && $key !== false);
    }

    public function count()
    {
        return count($this->filterCollection);
    }
}
