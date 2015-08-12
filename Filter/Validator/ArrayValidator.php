<?php
namespace ABK\QueryBundle\Filter\Validator;

use ABK\QueryBundle\Filter\FieldMapperInterface;
use ABK\QueryBundle\Filter\Filter;
use ABK\QueryBundle\Filter\Handler\Factory;
use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;
use ABK\QueryBundle\Filter\Operators\Logical\AbstractLogicalOperator;
use ABK\QueryBundle\Filter\Operators\Names;

class ArrayValidator
{
    protected $fieldMapper;

    /**
     * @var \ABK\QueryBundle\Filter\Handler\Factory
     */
    protected $handlerFactory;

    public function __construct(FieldMapperInterface $fieldMapper)
    {
        $this->fieldMapper = $fieldMapper;
        $this->handlerFactory = new Factory();
    }

    public function isValid(array $data, Filter $filter)
    {
        $logicalValidationSum = 0;
        $lastLogicalOperator = null;

        foreach ($filter->getOperators() as $operator) {
            if ($operator instanceof ComparisonOperatorInterface) {

                $handler = $this->handlerFactory->getHandler($operator);

                /**
                 * This is based on the idea that boolean will be cast to integer (TRUE -> 1 and FALSE -> 0)
                 * and that the operator 'AND' represents the mathematical '*' and 'OR' represents '+'.
                 * This will happen for example: (TRUE and FALSE or TRUE and TRUE) -> (1 * 0 + 1 * 1) = 1
                 */
                $currentValidation = (int)$handler->doesMatch(
                    $this->getValue($operator->getField(), $data)
                );

                if ($lastLogicalOperator === Names::LOGICAL_OR) {
                    $logicalValidationSum = $logicalValidationSum + $currentValidation;
                } elseif ($lastLogicalOperator === Names::LOGICAL_AND) {
                    $logicalValidationSum = $logicalValidationSum * $currentValidation;
                } elseif ($lastLogicalOperator === null) {
                    $logicalValidationSum = $currentValidation;
                }
            }

            if ($operator instanceof AbstractLogicalOperator) {
                $lastLogicalOperator = $operator->getName();
            }

            if ($lastLogicalOperator === Names::LOGICAL_OR && $logicalValidationSum >=1) {
                return true;
            }
        };

        return $logicalValidationSum >= 1 || count($filter->getOperators()) === 0;

    }

    protected function getValue($field, array $data)
    {
        $mappedField = $this->fieldMapper->map($field);
        if (isset($data[$mappedField])) {
            return $data[$mappedField];
        }
        return null;
    }
}
