<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\Identical;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class IdenticalTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new Identical($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(1, 1, true, 'Single number should match'),
            array(null, 0, false, 'Single number different types should mismatch'),
            array('1', 1, false, 'Single number different types should mismatch'),
            array(true, 1, false, 'Single number different types should mismatch'),
            array('string', 'string', true, 'Single should match'),
            array('not_match', 'string', false, 'Single should mismatch'),
            array(array("chinchilla", 1, "2"), 2, false, 'Number in array with different type should mismatch'),
            array(array("chinchilla", 1, "2"), 1, true, 'Number in array should match'),
        );
    }
}
