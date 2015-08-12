<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\NotIdentical;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class NotIdenticalTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new NotIdentical($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(1, 1, false, 'Single number should mismatch'),
            array(null, 0, true, 'Single number different types should match'),
            array('1', 1, true, 'Single number different types should match'),
            array(true, 1, true, 'Single number different types should match'),
            array('string', 'string', false, 'Single should mismatch'),
            array('not_match', 'string', true, 'Single should match'),
            array(array("chinchilla", 1, "2"), 2, true, 'Number in array with different type should mismatch'),
            array(array("chinchilla", 1, "2"), 1, false, 'Number in array should mismatch'),
            array(array("chinchilla", 1, "2"), "2", false, 'Number in array should mismatch'),
        );
    }
}
