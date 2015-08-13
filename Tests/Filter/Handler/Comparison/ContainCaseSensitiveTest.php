<?php

namespace ABK\QueryBundle\Tests\Filter\Handler\Comparison;

use ABK\QueryBundle\Filter\Handler\Comparison\Contain;
use ABK\QueryBundle\Filter\Handler\HandlerInterface;

/**
 * @group Filter
 */
class ContainCaseSensitiveTest extends AbstractOperatorHandlerTest
{
    /**
     * @return HandlerInterface
     */
    protected function getTestSubject()
    {
        $this->operatorMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Operators\Comparison\Contain'
        )->disableOriginalConstructor()->getMock();

        $this->operatorMock->expects($this->any())->method('isCaseSensitive')->will($this->returnValue(true));
        return new Contain($this->operatorMock, $this->factoryMock);
    }

    public function getValues()
    {
        return array(
            array('Some value to test with', 'value', true, 'should match simple match'),
            array('Some value to test with', 'values', false, 'should not match'),
            array('Some value to test with', 'sOmE', false, 'should not match with different letter case'),
            array('Some vaLue tO test with', 'Some vaLue tO', true, 'should match text with case sensitive match'),
            array('Some vaLue tO test with', ' ', true, 'should match white space'),
            array('Some vaLue tO test with', '', false, 'should not match empty space'),
            array('Some vaLue tO test with', null, false, 'should not match null'),
            array('Some vaLue tO test with', false, false, 'should not match false'),
            array('Some vaLue with ƔǶԔ special char', 'with ƔǶԔ', true, 'should match special chars'),
        );
    }
}
