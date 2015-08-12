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

    public function testSetLimit()
    {
        $this->subject = new Filter();
        $this->assertSame(null, $this->subject->getLimit(), 'init limit should ne null');
        $this->subject->setLimit(10);
        $this->assertSame(10, $this->subject->getLimit(), 'set limit correctly');
        $this->subject->setLimit('string value');
        $this->assertSame(0, $this->subject->getLimit(), 'every value is converted to int values');
    }

    public function testSetOffset()
    {
        $this->subject = new Filter();
        $this->assertSame(null, $this->subject->getOffset(), 'init offset should ne null');
        $this->subject->setOffset(10);
        $this->assertSame(10, $this->subject->getOffset(), 'set offset correctly');
        $this->subject->setOffset('string value');
        $this->assertSame(0, $this->subject->getOffset(), 'every value is converted to int values');
    }
}
