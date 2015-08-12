<?php

namespace ABK\QueryBundle\Tests\Filter\Operators\Comparison;

use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Structure\NestedFilter;
use ABK\QueryBundle\Filter\Operators\Types;

/**
 * @group Filter
 */
class StructureOperationTest extends \PHPUnit_Framework_TestCase
{

    public function testNestedFilter()
    {
        $filterMock = $this->getMock('ABK\QueryBundle\Filter\Filter');
        $parentFilterMock = $this->getMock('ABK\QueryBundle\Filter\Filter');
        $subject = new NestedFilter($filterMock);
        $subject->setParent($parentFilterMock);

        $this->assertEquals(Types::STRUCTURE, $subject->getType());
        $this->assertEquals(Names::NESTED_FILTER, $subject->getName());
        $this->assertSame($filterMock, $subject->getFilter());
        $this->assertSame($parentFilterMock, $subject->getParent());
    }
}
