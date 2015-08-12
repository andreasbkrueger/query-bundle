<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\GreaterThan;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class GreaterThanTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new GreaterThan($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(2, 1, true, 'Number should match'),
            array(3, 1, true, 'Number should match'),
            array(2, 2, false, 'Number should mismatch'),
            array('3', 2, true, 'Number with type casting should match'),
            array('2', '3', false, 'String should mismatch'),
            array(array(1, 2, 3, 4, 5), 3, true, 'In array should match'),
            array(array(1, 2, 3, 4, 5), 5, false, 'In array should mismatch'),
            array(array(2, 3, 4, 5), 7, false, 'In array should mismatch'),
        );
    }
}
