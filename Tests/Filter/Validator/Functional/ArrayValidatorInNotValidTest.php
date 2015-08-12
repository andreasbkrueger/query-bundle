<?php
namespace ABK\QueryBundle\Tests\Filter\Validator\Functional;

use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;

/**
 * @group Functional
 */
class ArrayValidatorIsNotValidTest extends AbstractArrayValidator
{

    /**
     * @dataProvider getFilterSets
     */
    public function testShouldReturnIsNotValid($filterSet, $msg)
    {
        $this->filterMock->expects($this->any())
            ->method('getOperators')
            ->will(
                $this->returnValue(
                    $filterSet
                )
            );

        $result = $this->subject->isValid($this->testArray, $this->filterMock);
        $this->assertFalse($result, $msg);
    }

    public function getFilterSets()
    {
        return array(

            // Equal
            array(
                array($this->getEqual('UNKNOWN_FIELD_KEY', 'some term')),
                'unknown field'
            ),
            array(
                array($this->getEqual(self::S1, 'NEVER_MATCH_THIS_STRING')),
                'one "equal" operator on pure string'
            ),
            array(
                array($this->getEqual(self::N1, '41')),
                'one "equal" operator on number with string'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'SomeTestString'),
                    $this->getAnd(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING')
                ),
                'two "equal" operators linked with "and" operator -> one does not match'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'NEVER_MATCH_THIS_STRING'),
                    $this->getOr(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING')
                ),
                'two "equal" operators linked with "or" operator -> no one does match'
            ),
            array(
                array(
                    $this->getEqual(self::S1, 'NEVER_MATCH_THIS_STRING'),
                    $this->getAnd(),
                    $this->getEqual(self::S2, 'NEVER_MATCH_THIS_STRING'),
                    $this->getOr(),
                    $this->getEqual(self::S3, 'NEVER_MATCH_THIS_STRING')
                ),
                'three "equal" operators linked with "and" and "or"  -> no one does match'
            ),

            // Not Equal
            array(
                array($this->getNotEqual(self::N1, '42')),
                'one "not equal" operator on number with string'
            ),
            array(
                array(
                    $this->getNotEqual(self::S3, 'array'),
                    $this->getOr(),
                    $this->getNotEqual(self::S3, 'of'),
                ),
                'two "not equal" operator on string array with all matching string'
            ),
            array(
                array($this->getNotEqual(self::V1, false)),
                'one "not equal" operator on NULL with FALSE'
            ),

            // Identical
            array(
                array(
                    $this->getIdentical(self::N1, "42")
                ),
                'one "identical" operator on number with string'
            ),
            array(
                array(
                    $this->getIdentical(self::V1, false)
                ),
                'one "identical" operator on null with false'
            ),
            array(
                array(
                    $this->getIdentical(self::V1, false),
                    $this->getOr(),
                    $this->getIdentical(self::V2, null),
                    $this->getOr(),
                    $this->getIdentical(self::V3, 1),
                    $this->getOr(),
                    $this->getIdentical(self::N5, 9)
                ),
                'four "identical" operator linked with "or" on special values -> no one does match'
            ),

            // Not Identical
            array(
                array(
                    $this->getNotIdentical(self::N1, 42)
                ),
                'one "not identical" operator on number with number -> match but should not'
            ),
            array(
                array(
                    $this->getNotIdentical(self::S3, "of")
                ),
                'one "identical" operator on number with string'
            ),

            // Less Than
            array(
                array(
                    $this->getLessThan(self::N6, 19)
                ),
                'one "less then" operator on array of numbers with number in range'
            ),
            array(
                array(
                    $this->getLessThan(self::N6, 19),
                    $this->getOr(),
                    $this->getLessThan(self::N5, 9)
                ),
                'two "less then" operators linked with "or" on array of numbers with number -> no one matches'
            ),

            // Less Than Equal
            array(
                array(
                    $this->getLessThanEqual(self::N6, 19)
                ),
                'one "less then equal" operator on array of numbers with number in range and not equal the min value'
            ),
            array(
                array(
                    $this->getLessThanEqual(self::N6, 19),
                    $this->getAnd(),
                    $this->getLessThanEqual(self::N5, 10)
                ),
                'two "less then equal" operators linked with "and" on array of numbers -> one does not match'
            ),

            // Greater Than
            array(
                array(
                    $this->getGreaterThan(self::N4, 1)
                ),
                'one "greater then" operator on number'
            ),
            array(
                array(
                    $this->getGreaterThan(self::N5, 14),
                    $this->getOr(),
                    $this->getGreaterThan(self::N6, 99)
                ),
                'two "greater then" operators linked with "or" on array of numbers with number -> no one matches'
            ),

            // Greater Than Equal
            array(
                array(
                    $this->getGreaterThanEqual(self::N4, 2)
                ),
                'one "greater then equal" operator on number'
            ),
            array(
                array(
                    $this->getGreaterThanEqual(self::N5, 999),
                    $this->getAnd(),
                    $this->getGreaterThanEqual(self::N6, 100),
                    $this->getOr(),
                    $this->getGreaterThanEqual(self::N1, 43),
                    $this->getAnd(),
                    $this->getGreaterThanEqual(self::N2, 56)
                ),
                'four "greater then" operators mixed linked on mixed numbers -> no one matches'
            ),

            // Mixed Operators
            array(
                array(
                    $this->getEqual(self::V2, 1),
                    $this->getOr(),
                    $this->getIdentical(self::S1, 'cecilia'),
                    $this->getAnd(),
                    $this->getLessThan(self::N2, 56),
                    $this->getOr(),
                    $this->getGreaterThanEqual(self::N1, 43)
                ),
                'four mixed operators with condition (FALSE OR FALSE AND TRUE OR FALSE)'
            ),
        );
    }
}
