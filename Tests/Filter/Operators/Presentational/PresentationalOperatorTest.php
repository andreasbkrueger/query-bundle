<?php

namespace ABK\QueryBundle\Tests\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException;
use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Presentational\AbstractPresentationalOperator;
use ABK\QueryBundle\Filter\Operators\Presentational\Order;
use ABK\QueryBundle\Filter\Operators\Types;

class PresentationalOperatorTest extends \PHPUnit_Framework_TestCase {

    protected $testOperatorType = Types::PRESENTATIONAL;

    /**
     * @dataProvider getSimpleOperators
     * @param AbstractPresentationalOperator $operatorClass
     * @param $name
     */
    public function testSimpleOperatorBehavior($operatorClass, $name)
    {
        $operatorClassName = $operatorClass;
        $operatorClass = 'ABK\QueryBundle\Filter\Operators\Presentational\\' . $operatorClass;

        if ($operatorClassName === 'Order') {
            $operator = new $operatorClass('field', Order::ASC);
        }

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
            array('Order', Names::ORDER)
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOrderThrowsException()
    {
        new Order('field', 'invalid_order_direction');
    }

    public function testOrderAcceptsValidDirections()
    {
        $subject = new Order('field', Order::ASC);
        $this->assertEquals(Order::ASC, $subject->getDirection());

        $subject = new Order('field', Order::DESC);
        $this->assertEquals(Order::DESC, $subject->getDirection());
    }
}