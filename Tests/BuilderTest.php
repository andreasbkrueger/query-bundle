<?php

namespace ABK\QueryBundle\Tests;

use ABK\QueryBundle\Builder\Builder;
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
            array('logicalOr', array()),
            array('logicalAnd', array()),
            array('end', array('', 1)),
        );
    }
}