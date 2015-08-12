<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\NotEqual;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class NotEqualTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new NotEqual($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(1, 1, false, 'Single number should mismatch'),
            array('1', 1, false, 'Single number with type casting should mismatch'),
            array(true, 2, false, 'Single number with type casting should mismatch'),
            array(false, 2, true, 'Single number with type casting should mismatch'),
            array('string', 'string_1', true, 'String should match'),
            array(null, 0, false, 'Single number with type casting should mismatch'),
            array(null, 1, true, 'Single number with type casting should match'),
            array('not_match', 'string', true, 'String should match'),
            array(array(1, 2, 3, 4), 2, false, 'Number in array should mismatch'),
            array(array(1, 2, 3, 4), 5, true, 'Number not in array should match'),
            array(array("dog", "cat", "ant", "chinchilla"), "chinchillas", true, 'String not in array should match'),
            array(array("Some", "Strings", "in", "array"), "array", false, 'String in array should mismatch'),
        );
    }
}
