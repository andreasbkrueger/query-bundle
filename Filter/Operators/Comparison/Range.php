<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\OperatorInterface;

class Range extends AbstractComparisonOperator
{
    const KEY_FROM = 'from';
    const KEY_TO = 'to';

    protected function setName()
    {
        $this->name = Names::RANGE;
    }

    /**
     * @return GreaterThanEqual
     */
    public function getFromOperator()
    {
        $value =  $this->getValue();
        return $value[self::KEY_FROM];
    }

    /**
     * @return LessThanEqual
     */
    public function getToOperator()
    {
        $value =  $this->getValue();
        return $value[self::KEY_TO];
    }

    public function __construct($field, $from, $to)
    {
        $this->field = $field;

        $from = new GreaterThanEqual($field, $from);
        $to = new LessThanEqual($field, $to);

        parent::__construct($field, array(self::KEY_FROM => $from, self::KEY_TO => $to));
    }
}
