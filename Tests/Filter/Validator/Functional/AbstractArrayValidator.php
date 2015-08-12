<?php
namespace ABK\QueryBundle\Tests\Filter\Validator\Functional;

use Doctrine\Common\Inflector\Inflector;
use ABK\QueryBundle\Filter\Operators\Names;
use ABK\QueryBundle\Filter\Operators\Types;
use ABK\QueryBundle\Filter\Validator\ArrayValidator;

abstract class AbstractArrayValidator extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayValidator
     */
    protected $subject;
    protected $fieldMapperMock;
    protected $filterMock;

    protected $testArray = array(
        'response_string_1' => 'SomeTestString',
        'response_string_2' => 'SomeOtherString',
        'response_string_3' => array('array', 'of', 'strings'),
        'response_number_1' => 42,
        'response_number_2' => 55,
        'response_number_3' => 0,
        'response_number_4' => 1,
        'response_number_5' => array(10, 11, 12, 13, 14),
        'response_number_6' => array(20, 42, 99),
        'response_value_1' => null,
        'response_value_2' => false,
        'response_value_3' => true,
        'response_value_4' => '',
    );

    const S1 = 's1';
    const S2 = 's2';
    const S3 = 's3';
    const N1 = 'n1';
    const N2 = 'n2';
    const N3 = 'n3';
    const N4 = 'n4';
    const N5 = 'n5';
    const N6 = 'n6';
    const V1 = 'v1';
    const V2 = 'v2';
    const V3 = 'v3';
    const V4 = 'v4';

    protected $fieldMapperMockMap = array(
        array(self::S1, 'response_string_1'),
        array(self::S2, 'response_string_2'),
        array(self::S3, 'response_string_3'),
        array(self::N1, 'response_number_1'),
        array(self::N2, 'response_number_2'),
        array(self::N3, 'response_number_3'),
        array(self::N4, 'response_number_4'),
        array(self::N5, 'response_number_5'),
        array(self::N6, 'response_number_6'),
        array(self::V1, 'response_value_1'),
        array(self::V2, 'response_value_2'),
        array(self::V3, 'response_value_3'),
        array(self::V4, 'response_value_4'),
    );

    public function setUp()
    {
        $this->fieldMapperMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\FieldMapperInterface'
        )->disableOriginalConstructor()->getMock();

        $this->fieldMapperMock
            ->expects($this->any())
            ->method('map')
            ->will(
                $this->returnValueMap($this->fieldMapperMockMap)
            );

        $this->filterMock = $this->getMockBuilder(
            'ABK\QueryBundle\Filter\Filter'
        )->disableOriginalConstructor()->getMock();

        $this->subject = new ArrayValidator($this->fieldMapperMock);
    }

    abstract public function getFilterSets();

    protected function getOperatorMock($type, $name, $field = null, $value = null)
    {
        $operatorClass = Inflector::camelize($name);
        $namespace = 'ABK\QueryBundle\Filter\Operators\\' . ucfirst($type);
        $operatorMock = $this->getMockBuilder(
            $namespace . '\\' . ($type === Types::LOGICAL ? ucfirst($type) : '') . ucfirst($operatorClass)
        )->disableOriginalConstructor()->getMock();

        if ($type === Types::COMPARISON) {
            $operatorMock->expects($this->any())->method('getField')->will($this->returnValue($field));
            $operatorMock->expects($this->any())->method('getValue')->will($this->returnValue($value));
        }

        $operatorMock->expects($this->any())->method('getName')->will($this->returnValue($name));
        $operatorMock->expects($this->any())->method('getType')->will($this->returnValue($type));
        return $operatorMock;
    }

    protected function getAnd()
    {
        return $this->getOperatorMock(Types::LOGICAL, Names::LOGICAL_AND);
    }

    protected function getOr()
    {
        return $this->getOperatorMock(Types::LOGICAL, Names::LOGICAL_OR);
    }

    protected function getEqual($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::EQUAL, $field, $value);
    }

    protected function getNotEqual($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::NOT_EQUAL, $field, $value);
    }

    protected function getIdentical($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::IDENTICAL, $field, $value);
    }

    protected function getNotIdentical($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::NOT_IDENTICAL, $field, $value);
    }

    protected function getLessThan($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::LESS_THAN, $field, $value);
    }

    protected function getLessThanEqual($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::LESS_THAN_EQUAL, $field, $value);
    }

    protected function getGreaterThan($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::GREATER_THAN, $field, $value);
    }

    protected function getGreaterThanEqual($field, $value)
    {
        return $this->getOperatorMock(Types::COMPARISON, Names::GREATER_THAN_EQUAL, $field, $value);
    }
}
