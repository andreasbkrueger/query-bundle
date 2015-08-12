<?php

namespace ABK\QueryBundle\Tests\Filter;

use ABK\QueryBundle\Filter\Filter;
use ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException;

/**
 * @group Filter
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filter
     */
    protected $subject;

    protected $abstractOperatorMock;


    public function setUp()
    {
        $this->abstractOperatorMock = $this->getMockForAbstractClass(
            'ABK\QueryBundle\Filter\Operators\AbstractOperator'
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongOperator()
    {
        $this->subject = new Filter(new \stdClass());
    }

    public function testConstructor()
    {
        $this->subject = new Filter($this->abstractOperatorMock);
        $operators = $this->subject->getOperators();
        $this->assertInstanceOf(
            'ABK\QueryBundle\Filter\Operators\OperatorInterface',
            $operators[0]
        );
    }

    public function testMultipleConstructorParams()
    {
        $this->subject = new Filter($this->abstractOperatorMock, $this->abstractOperatorMock);
        $operators = $this->subject->getOperators();
        $this->assertEquals(2, count($operators));
    }

    public function testAddOperator()
    {
        $this->subject = new Filter();
        $this->subject->addOperator($this->abstractOperatorMock);
        $operators = $this->subject->getOperators();
        $this->assertInstanceOf(
            'ABK\QueryBundle\Filter\Operators\OperatorInterface',
            $operators[0]
        );
    }

    public function testNameDefinition()
    {
        $this->subject = new Filter();
        $testName = 'test-name';
        $this->subject->setName($testName);
        $this->assertEquals($testName, $this->subject->getName());
    }
}
