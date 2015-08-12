<?php

namespace ABK\QueryBundle\Tests\Filter;

use ABK\QueryBundle\Filter\FilterCollection;
use ABK\QueryBundle\Filter\Filter;

/**
 * @group Filter
 */
class FilterCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilterCollection
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new FilterCollection();
    }

    public function testAddFilterAndIterate()
    {
        $this->subject->add(new Filter());
        $this->assertCount(1, $this->subject);
        $this->subject->add(new Filter());
        $this->assertCount(2, $this->subject);

        foreach ($this->subject as $filter) {
            $this->assertInstanceOf('ABK\QueryBundle\Filter\Filter', $filter);
        }
        $this->subject->rewind();
        $this->subject->next();
        $this->assertEquals(1, $this->subject->key());
    }
}
