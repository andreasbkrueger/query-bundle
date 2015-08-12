<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\GreaterThanEqual;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class GreaterThanEqualTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new GreaterThanEqual($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(1, 1, true, 'Number should match'),
            array(2, 1, true, 'Number should match'),
            array(0, 1, false, 'Number should mismatch'),
            array(99, 100, false, 'Number should mismatch'),
            array(50, 100, false, 'Number should mismatch'),
            array('2', 1, true, 'Number with type casting should match'),
            array('2', '3', false, 'String should mismatch'),
            array(array(1, 2, 3, 4, 5), 3, true, 'In array should match'),
            array(array(1, 2, 3, 4, 5), 5, true, 'In array should match'),
            array(array(2, 3, 4, 5), 7, false, 'In array should mismatch'),
        );
    }
}
