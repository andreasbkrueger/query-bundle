<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\LessThan;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class LessThanTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new LessThan($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(2, 3, true, 'number should match'),
            array(2, 2, false, 'number should mismatch'),
            array(50, 100, true, 'number should match'),
            array('2', 1, false, 'Number with type casting should mismatch'),
            array('2', 3, true, 'Number with type casting should match'),
            array('2', '3', true, 'String should match'),
            array(array(1, 2, 3, 4, 5), 0, false, 'In array should mismatch'),
            array(array(2, 3, 4, 5), 6, true, 'In array should match'),
            array(array(2, 3, 4, 5), 1, false, 'In array should match'),
        );
    }
}
