<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\Contain;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class ContainCaseInsensitiveTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\Contain'
        )->disableOriginalConstructor()->getMock();

        $this->operatorMock->expects($this->any())->method('isCaseSensitive')->will($this->returnValue(false));
        return new Contain($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array('Some value to test with', 'value', true, 'should match simple match'),
            array('Some value to test with', 'values', false, 'should not match'),
            array('Some value to test with', 'sOmE', true, 'should match even with different letter case'),
            array('Some vaLue tO test with', 'some value to', true, 'should match text with case insensitive'),
            array('Some vaLue tO test with', ' ', true, 'should match white space'),
            array('Some vaLue tO test with', '', false, 'should not match empty space'),
            array('Some vaLue tO test with', null, false, 'should not match null'),
            array('Some vaLue tO test with', false, false, 'should not match false'),
            array('Some vaLue with ƔǶԔ special char', 'with ƔǶԔ', true, 'should match special chars'),
        );
    }
}
