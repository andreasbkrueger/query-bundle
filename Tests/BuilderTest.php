<?php

namespace ABK\QueryBundle\Tests;

use ABK\QueryBundle\Builder\Builder;
use ABK\QueryBundle\Filter\Operators\Names;

class BuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Builder();
    }

    /**
     * @dataProvider getAllFluentFunctions
     */
    public function testFluentInterface($functionName, $arguments)
    {
        $qb = $this->subject;

        // Need to start at least 1 query to be able to invoke operator functions
        $qb->query();

        $result = call_user_func_array(array($qb, $functionName), $arguments);
        $this->assertSame($qb, $result);
    }

    public function getAllFluentFunctions()
    {
        return array(
            array('query', array()),
            array('filter', array()),
            array('isEqual', array('', 1)),
            array('isNotEqual', array('', 1)),
            array('isIdentical', array('', 1)),
            array('isNotIdentical', array('', 1)),
            array('isGreaterThanEqual', array('', 1)),
            array('isGreaterThan', array('', 1)),
            array('isLessThanEqual', array('', 1)),
            array('isLessThan', array('', 1)),
            array('logicalOr', array()),
            array('logicalAnd', array()),
            array('limit', array(1)),
            array('offset', array(1)),
            array('order', array('', 'asc')),
            array('end', array()),
        );
    }

    /**
     * @dataProvider getAllOperatorFunctions
     */
    public function testBuilderShouldUseTheCorrectOperators($functionName, $arguments, $expectedOperatorName)
    {
        $qb = $this->subject;

        // Need to start at least 1 query to be able to invoke operator functions
        $qb->query();
        call_user_func_array(array($qb, $functionName), $arguments);

        $query = $qb->getQuery();
        $operators = $query->getOperators();

        $this->assertEquals($expectedOperatorName, reset($operators)->getName());

    }

    public function getAllOperatorFunctions()
    {
        return array(
            array('isEqual', array('', 1), Names::EQUAL),
            array('shouldContain', array('', 1), Names::CONTAIN),
            array('isNotEqual', array('', 1), Names::NOT_EQUAL),
            array('isIdentical', array('', 1), Names::IDENTICAL),
            array('isNotIdentical', array('', 1), Names::NOT_IDENTICAL),
            array('isGreaterThanEqual', array('', 1), Names::GREATER_THAN_EQUAL),
            array('isGreaterThan', array('', 1), Names::GREATER_THAN),
            array('isLessThanEqual', array('', 1), Names::LESS_THAN_EQUAL),
            array('isLessThan', array('', 1), Names::LESS_THAN),
            array('logicalOr', array(), Names::LOGICAL_OR),
            array('logicalAnd', array(), Names::LOGICAL_AND),
            array('order', array('', 'asc'), Names::ORDER),
            array('filter', array(), Names::NESTED_FILTER)
        );
    }

    public function testBuilderShouldAppendOperators()
    {
        $qb = $this->subject;

        $qb->query()
            ->isEqual('testField', 'value')
            ->logicalAnd()
            ->isIdentical('testField', 'value')
            ->logicalOr()
            ->filter('subFilterId')
                ->isGreaterThan('testField', 'value')
                ->logicalAnd()
                ->isLessThan('testField', 'value')
                ->logicalOr()
                ->shouldContain('testField', 'value')
            ->end()
        ->end();

        $operators = $qb->getQuery()->getOperators();

        $this->assertEquals(Names::EQUAL, $operators[0]->getName());
        $this->assertEquals(Names::LOGICAL_AND, $operators[1]->getName());
        $this->assertEquals(Names::IDENTICAL, $operators[2]->getName());
        $this->assertEquals(Names::LOGICAL_OR, $operators[3]->getName());
        $this->assertEquals(Names::NESTED_FILTER, $operators[4]->getName());

        $nestedOperators = $operators[4]->getFilter()->getOperators();

        $this->assertEquals(Names::GREATER_THAN, $nestedOperators[0]->getName());
        $this->assertEquals(Names::LOGICAL_AND, $nestedOperators[1]->getName());
        $this->assertEquals(Names::LESS_THAN, $nestedOperators[2]->getName());
        $this->assertEquals(Names::LOGICAL_OR, $nestedOperators[3]->getName());
        $this->assertEquals(Names::CONTAIN, $nestedOperators[4]->getName());
    }
}