<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Filter\Operators;

class Names
{
    const EQUAL = 'equal';
    const NOT_EQUAL = 'not_equal';
    const IDENTICAL = 'identical';
    const NOT_IDENTICAL = 'not_identical';
    const GREATER_THAN = 'greater_than';
    const GREATER_THAN_EQUAL = 'greater_than_equal';
    const LESS_THAN = 'less_than';
    const LESS_THAN_EQUAL = 'less_than_equal';
    const RANGE = 'range';

    const LOGICAL_AND = 'and';
    const LOGICAL_OR = 'or';

    const NESTED_FILTER = 'nested_filter';

    const ORDER = 'order';
}
