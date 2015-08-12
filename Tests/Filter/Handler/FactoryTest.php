<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Tests\Filter\Handler;


use ABK\QueryBundle\Filter\Handler\Factory;
use ABK\QueryBundle\Filter\Operators\OperatorInterface;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    protected $subject;

    /**
     * @var OperatorInterface
     */
    protected $operatorMock;

    public function setUp()
    {
        $this->subject = new Factory();
    }

    public function testGetHandlerShouldReturnOperatorHandler()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface'
        )->disableOriginalConstructor()->getMock();

        $this->operatorMock->expects($this->any())->method('getName')->will($this->returnValue('equal'));
        $this->operatorMock->expects($this->any())->method('getType')->will($this->returnValue('comparison'));

        $firstResult = $this->subject->getHandler($this->operatorMock);

        $this->assertInstanceOf(
            'ABK\QueryBundle\Filter\Handler\Comparison\HandlerInterface',
            $firstResult
        );

        $secondResult = $this->subject->getHandler($this->operatorMock);

        $this->assertSame($firstResult, $secondResult, 'Test if only creating one instance per handler of same type');

    }

    public function testGetHandlerWithNotJetSupportedOperatorInterface()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\OperatorInterface'
        )->disableOriginalConstructor()->getMock();

        $this->operatorMock->expects($this->any())->method('getName')->will($this->returnValue('equal'));
        $this->operatorMock->expects($this->any())->method('getType')->will($this->returnValue('comparison'));

        $result = $this->subject->getHandler($this->operatorMock);

        $this->assertNull($result);
    }

    /**
     * @expectedException ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException
     */
    public function testGetHandlerThrowsExceptionWithNotRegisteredHandlers()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\OperatorInterface'
        )->disableOriginalConstructor()->getMock();

        $this->operatorMock->expects($this->any())->method('getName')->will($this->returnValue('FALSE_NAME'));
        $this->operatorMock->expects($this->any())->method('getType')->will($this->returnValue('FALSE_TYPE'));

        $this->subject->getHandler($this->operatorMock);
    }
}
