<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\Range;

/**
 * @group Filter
 */
class RangeTest extends \PHPUnit_Framework_TestCase
{
    protected $operatorMock;

    protected $fromOperatorMock;
    protected $toOperatorMock;

    protected $fromHandlerMock;
    protected $toHandlerMock;

    protected $factoryMock;

    /**
     * @var Range
     */
    protected $subject;

    public function setUp()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\Range'
        )->disableOriginalConstructor()->getMock();

        $this->fromOperatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\GreaterThanEqual'
        )->disableOriginalConstructor()->getMock();

        $this->toOperatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\LessThanEqual'
        )->disableOriginalConstructor()->getMock();

        $this->fromHandlerMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Handler\Comparison\HandlerInterface'
        )->disableOriginalConstructor()->getMock();

        $this->toHandlerMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Handler\Comparison\HandlerInterface'
        )->disableOriginalConstructor()->getMock();

        $this->factoryMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Handler\Factory'
        )->disableOriginalConstructor()->getMock();

        $this->factoryMock
            ->expects($this->any())
            ->method('getHandler')
            ->will(
                $this->returnValueMap(
                    array(
                        array($this->fromOperatorMock, $this->fromHandlerMock),
                        array($this->toOperatorMock, $this->toHandlerMock)
                    )
                )
            );

        $this->operatorMock
            ->expects($this->any())
            ->method('getFromOperator')
            ->will(
                $this->returnValue($this->fromOperatorMock)
            );

        $this->operatorMock
            ->expects($this->any())
            ->method('getToOperator')
            ->will(
                $this->returnValue($this->toOperatorMock)
            );

        $this->subject = new Range($this->operatorMock, $this->factoryMock);
    }

    /**
     * @dataProvider getTestResultPossibilities
     */
    public function testDoesMatchRange($matchFrom, $matchTo, $expected)
    {
        $testValue = 1;

        $this->fromHandlerMock
            ->expects($this->any())
            ->method('doesMatch')
            ->with($testValue)
            ->will(
                $this->returnValue($matchFrom)
            );

        $this->toHandlerMock
            ->expects($this->any())
            ->method('doesMatch')
            ->with($testValue)
            ->will(
                $this->returnValue($matchTo)
            );

        $result = $this->subject->doesMatch($testValue);

        $this->assertSame($expected, $result);
    }

    public function getTestResultPossibilities()
    {
        return array(
            array(true, true, true),
            array(true, false, false),
            array(false, true, false),
            array(false, false, false)
        );
    }

    /**
     * @dataProvider getArrayRanges
     */
    public function testArrayValueShouldUseArrayAsRange($testArray, $valueFrom, $valueTo)
    {
        $this->fromHandlerMock
            ->expects($this->once())
            ->method('doesMatch')
            ->with($valueFrom)
            ->will(
                $this->returnValue(true)
            );

        $this->toHandlerMock
            ->expects($this->once())
            ->method('doesMatch')
            ->with($valueTo);

        $this->subject->doesMatch($testArray);
    }

    public function getArrayRanges()
    {
        return array(
            array(array(1, 2, 3, 4, 5), 1, 5),
            array(array(10), 10, 10)
        );
    }
}
