<?php

namespace ABK\QueryBundle\Tests\DependencyInjection;


use ABK\QueryBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Configuration
     */
    protected $subject;
    public function setUp()
    {
        $this->subject = new Configuration();
    }

    public function testGetConfigTreeBuilderShouldReturnTreeBuilderInstance()
    {
        $result = $this->subject->getConfigTreeBuilder();
        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $result);
    }
}
