<?php
namespace ABK\QueryBundle\Tests\Filter\Validator\Functional;

use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;

/**
 * @group Functional
 */
class ArrayValidatorIsValidTest extends AbstractArrayValidator
{

    /**
     * @dataProvider getFilterSets
     */
    public function testShouldReturnIsValid($filterSet, $msg)
    {
        $this->filterMock->expects($this->any())
            ->method('getOperators')
            ->will(
                $this->returnValue(
                    $filterSet
                )
            );

        $result = $this->subject->isValid($this->testArray, $this->filterMock);
        $this->assertTrue($result, $msg);
    }

    public function getFilterSets()
    {
        return array(

            // Equal
            array(
                array($this->getEqual(self::S1, 'SomeTestString')),
                'one "equal" operator on pure string'
            ),
            array(
                array($this->getEqual(self::S1, 'SomeTestString')),
                'one "equal" operator on pure string'
            ),
            array(
                array($this->getEqual(self::N1, '42')),
                'one "equal" operator on number with string'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'SomeTestString'),
                    $this->getAnd(),
                    $this->getEqual(self::S2, 'SomeOtherString')
                ),
                'two "equal" operators linked with "and" operator -> both are matching'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'SomeTestString'),
                    $this->getOr(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING')
                ),
                'two "equal" operators linked with "or" operator -> one does not match'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'NEVER_MATCH_THIS_STRING'),
                    $this->getAnd(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING'),
                    $this->getOr(),
                    $this->getEqual(self::S3, 'strings')
                ),
                'three "equal" operators linked with "and" and "or"  -> only the last one matches'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'NEVER_MATCH_THIS_STRING'),
                    $this->getOr(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING'),
                    $this->getOr(),
                    $this->getEqual(self::S3, 'strings')
                ),
                'three "equal" operators linked with "or" -> only the last one matches'
            ),

            // Not Equal
            array(
                array(
                    $this->getNotEqual(self::S1, 'NEVER_MATCH_THIS_STRING'),
                    $this->getAnd(),
                    $this->getNotEqual(self::S2, 'NEVER_MATCH_THIS_STRING')
                ),
                'two "not equal" operators linked with "and" -> both are not matching'
            ),
            array(
                array(
                    $this->getNotEqual(self::S3, 'string'),
                    $this->getOr(),
                    $this->getNotEqual(self::S3, 'NEVER_MATCH_THIS_STRING')
                ),
                'two "not equal" operators linked with "or" -> one does match'
            ),

            // Identical
            array(
                array(
                    $this->getIdentical(self::N1, 42)
                ),
                'one "identical" operator on number with number'
            ),
            array(
                array(
                    $this->getIdentical(self::V1, null)
                ),
                'one "identical" operator on null with false'
            ),
            array(
                array(
                    $this->getIdentical(self::V1, null),
                    $this->getAnd(),
                    $this->getIdentical(self::V2, false),
                    $this->getAnd(),
                    $this->getIdentical(self::V3, true),
                    $this->getAnd(),
                    $this->getIdentical(self::V4, '')
                ),
                'four "identical" operator on special values -> all matching'
            ),

            // Not Identical
            array(
                array(
                    $this->getNotIdentical(self::V1, false)
                ),
                'one "identical" operator on NULL with false'
            ),

            // Less Than
            array(
                array(
                    $this->getLessThan(self::N6, 100)
                ),
                'one "less then" operator on array of numbers with number less than range'
            ),
            array(
                array(
                    $this->getLessThan(self::N6, 100),
                    $this->getOr(),
                    $this->getLessThan(self::N5, 16)
                ),
                'two "less then" operators linked with "or" on array of numbers with number -> first one matches'
            ),

            // Less Than Equal
            array(
                array(
                    $this->getLessThanEqual(self::N6, 20)
                ),
                'one "less then equal" operator on array of numbers with number in range'
            ),
            array(
                array(
                    $this->getLessThanEqual(self::N6, 20),
                    $this->getAnd(),
                    $this->getLessThanEqual(self::N5, 10)
                ),
                'two "less then equal" operators linked with "and" on array of numbers with number -> both are matching'
            ),

            // Greater Than
            array(
                array(
                    $this->getGreaterThan(self::N4, -1)
                ),
                'one "greater then" operator on number'
            ),
            array(
                array(
                    $this->getGreaterThan(self::N5, 5),
                    $this->getOr(),
                    $this->getGreaterThan(self::N6, 999)
                ),
                'two "greater then" operators linked with "or" on array of numbers with number -> first one matches'
            ),

            // Greater Than Equal
            array(
                array(
                    $this->getGreaterThanEqual(self::N4, 1)
                ),
                'one "greater then equal" operator on number'
            ),
            array(
                array(
                    $this->getGreaterThanEqual(self::N5, 20),
                    $this->getAnd(),
                    $this->getGreaterThanEqual(self::N6, 100),
                    $this->getOr(),
                    $this->getGreaterThanEqual(self::N1, 41),
                    $this->getAnd(),
                    $this->getGreaterThanEqual(self::N2, 55)
                ),
                'four "greater then" operators mixed linked on mixed numbers -> second "and" link matches'
            ),

            // Mixed Operators
            array(
                array(
                    $this->getEqual(self::V2, 1),
                    $this->getOr(),
                    $this->getIdentical(self::S1, 'cecilia'),
                    $this->getAnd(),
                    $this->getGreaterThanEqual(self::N1, 43),
                    $this->getOr(),
                    $this->getLessThan(self::N2, 56)
                ),
                'four mixed operators with condition (FALSE OR FALSE AND FALSE OR TRUE)'
            ),
        );
    }
}
