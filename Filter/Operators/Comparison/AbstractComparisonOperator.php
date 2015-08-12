<?php
/**
 * @author: Andreas Krueger 
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\AbstractOperator;
use ABK\QueryBundle\Filter\Operators\Types;

abstract class AbstractComparisonOperator extends AbstractOperator implements ComparisonOperatorInterface
{
    /**
     * @var string
     */
    protected $field;
    protected $value;

    protected function setType()
    {
        $this->type = Types::COMPARISON;
    }

    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
