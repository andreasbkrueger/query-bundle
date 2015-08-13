<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Tests\Filter\Operators\Comparison;


use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;
use ABK\QueryBundle\Filter\Operators\Comparison\Contain;
use ABK\QueryBundle\Filter\Operators\Comparison\Equal;
use ABK\QueryBundle\Filter\Operators\Comparison\GreaterThan;
use ABK\QueryBundle\Filter\Operators\Comparison\GreaterThanEqual;
use ABK\QueryBundle\Filter\Operators\Comparison\Identical;
use ABK\QueryBundle\Filter\Operators\Comparison\LessThan;
use ABK\QueryBundle\Filter\Operators\Comparison\LessThanEqual;
use ABK\QueryBundle\Filter\Operators\Comparison\Range;
use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;

/**
 * @group Filter
 */
class ComparisonOperationTest extends \PHPUnit_Framework_TestCase
{

    protected $testField = 'some_key';
    protected $testValue = 'some_value';
    protected $testOperatorType = Types::COMPARISON;
    protected $testRangeFrom = 5;
    protected $testRangeTo = 10;

    /**
     * @dataProvider getSimpleOperators
     * @param ComparisonOperatorInterface $operatorClass
     * @param $name
     */
    public function testSimpleOperatorBehavior($operatorClass, $name)
    {
        $operatorClass = 'ABK\QueryBundle\Filter\Operators\Comparison\\' . $operatorClass;
        $operator = new $operatorClass($this->testField, $this->testValue);

        $this->assertEquals(
            $this->testValue,
            $operator->getValue(),
            'The given value "' . $this->testField . '" was not set correctly'
        );

        $this->makeDefaultAssertions($operator, $name);

    }

    public function testRangeOperatorBehavior()
    {
        $operator = new Range($this->testField, $this->testRangeFrom, $this->testRangeTo);

        $expectedValue = array(
            Range::KEY_FROM => new GreaterThanEqual($this->testField, $this->testRangeFrom),
            Range::KEY_TO => new LessThanEqual($this->testField, $this->testRangeTo)
        );

        $this->assertEquals(
            $expectedValue,
            $operator->getValue(),
            'Wrong value in prepared range'
        );

        $this->makeDefaultAssertions($operator, 'range');
    }

    public function testContainsOperatorBehavior()
    {
        $operator = new Contain($this->testField, $this->testValue);
        $this->assertFalse(
            $operator->isCaseSensitive(),
            'case sensitive is false by default'
        );

        $operator = new Contain($this->testField, $this->testValue, true);
        $this->assertTrue(
            $operator->isCaseSensitive(),
            'case sensitive can be set to true'
        );
    }

    public function makeDefaultAssertions($operator, $name)
    {
        $this->assertEquals(
            $this->testField,
            $operator->getField(),
            'The given field "' . $this->testField . '" was not set correctly'
        );

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
            array('Equal', Names::EQUAL),
            array('GreaterThan', Names::GREATER_THAN),
            array('GreaterThanEqual', Names::GREATER_THAN_EQUAL),
            array('Identical', Names::IDENTICAL),
            array('LessThan', Names::LESS_THAN),
            array('LessThanEqual', Names::LESS_THAN_EQUAL),
            array('NotEqual', Names::NOT_EQUAL),
            array('NotIdentical', Names::NOT_IDENTICAL),
            array('Contain', Names::CONTAIN),
        );
    }
}
