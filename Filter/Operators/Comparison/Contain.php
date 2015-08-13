<?php

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;

class Contain extends AbstractComparisonOperator
{
    /**
     * @var bool
     */
    protected $caseSensitive = false;

    public function __construct($field, $value, $caseSensitive = false)
    {
        $this->caseSensitive = $caseSensitive;
        parent::__construct($field, $value);
    }

    protected function setName()
    {
        $this->name = Names::CONTAIN;
    }

    public function isCaseSensitive()
    {
        return $this->caseSensitive;
    }
}
