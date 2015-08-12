<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Tests\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;
use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;

/**
 * @group Filter
 */
class LogicalOperationTest extends \PHPUnit_Framework_TestCase
{
    protected $testOperatorType = Types::LOGICAL;

    /**
     * @dataProvider getSimpleOperators
     * @param ComparisonOperatorInterface $operatorClass
     * @param $name
     */
    public function testSimpleOperatorBehavior($operatorClass, $name)
    {
        $operatorClass = 'ABK\QueryBundle\Filter\Operators\Logical\\' . $operatorClass;
        $operator = new $operatorClass();

        $this->assertEquals(
            $name,
            $operator->getName(),
            'The defined name of the operator "' . $operator->getName() . '" is not correct'
        );

        $this->assertEquals(
            $this->testOperatorType,
            $operator->getType(),
            'The defined type of the operator "' . $operator->getType() . '" is not correct'
        );

    }

    public function getSimpleOperators()
    {
        return array(
            array('LogicalAnd', Names::LOGICAL_AND),
            array('LogicalOr', Names::LOGICAL_OR),
        );
    }
}
