<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\Equal;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class EqualTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        return new Equal($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array(1, 1, true, 'Single number should match'),
            array('1', 1, true, 'Single number with type casting should match'),
            array(true, 1, true, 'Single number with type casting should match'),
            array('string', 'string', true, 'String should match'),
            array(null, 0, true, 'Single number with type casting should match'),
            array(null, 1, false, 'Single number with type casting should mismatch'),
            array('not_match', 'string', false, 'String should mismatch'),
            array(array(1, 2, 3, 4), 2, true, 'Number in array should match'),
            array(array(1, 2, 3, 4), 5, false, 'Number in array should mismatch'),
            array(array("dog", "cat", "ant", "chinchilla"), "chinchilla", true, 'String in array should match'),
            array(array("Some", "Strings", "in", "array"), "no match", false, 'String in array should mismatch'),
        );
    }
}
