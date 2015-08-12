<?php

namespace ABK\QueryBundle\Tests\Filter\Operators\Comparison;


use ABK\QueryBundle\Filter\Operators\Comparison\Range;
use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;

class RangeTest extends \PHPUnit_Framework_TestCase {

    public function testRangeOperator()
    {
        $testField = 'test-field';
        $testFrom = 3;
        $testTo = 5;
        $subject = new Range($testField, $testFrom, $testTo);

        $this->assertEquals($testField, $subject->getField());
        $this->assertEquals(Names::RANGE, $subject->getName());
        $this->assertEquals(Types::COMPARISON, $subject->getType());

        $fromOperator = $subject->getFromOperator();
        $this->assertSame($testFrom, $fromOperator->getValue());

        $toOperator = $subject->getToOperator();
        $this->assertSame($testTo, $toOperator->getValue());
    }
}