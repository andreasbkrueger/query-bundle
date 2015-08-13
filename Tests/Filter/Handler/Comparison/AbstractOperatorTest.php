<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\HandlerInterface;

abstract class AbstractOperatorHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $operatorMock;
    protected $factoryMock;
    protected $subject;

    public function setUp()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface'
        )->disableOriginalConstructor()->getMock();

        $this->factoryMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Handler\Factory'
        )->disableOriginalConstructor()->getMock();
    }

    /**
     * @dataProvider getValues
     */
    public function testDoesMatch($valueToTestOn, $valueToTestWith, $expectedResult, $errorMessage)
    {
        $this->subject = $this->getTestSubject();
        $this->operatorMock->expects($this->any())->method('getValue')->will($this->returnValue($valueToTestWith));

        $result = $this->subject->doesMatch($valueToTestOn);
        if ($expectedResult === true) {
            $this->assertTrue($result, $errorMessage);
        } else {
            $this->assertFalse($result, $errorMessage);
        }
    }

    /**
     * @return HandlerInterface
     */
    abstract protected function getTestSubject();
    abstract public function getValues();
}
