<?php
namespace ABK\QueryBundle\Filter\Handler;

use Doctrine\Common\Inflector\Inflector;
use ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException;
use ABK\QueryBundle\Filter\Handler\Comparison\HandlerInterface as ComparisonHandlerInterface;
use ABK\QueryBundle\Filter\Operators\Comparison\ComparisonOperatorInterface;
use ABK\QueryBundle\Filter\Operators\OperatorInterface;

class Factory
{
    protected $registeredHandlers = array(
        'comparison' => array(
            'equal',
            'not_equal',
            'greater_than',
            'greater_than_equal',
            'identical',
            'not_identical',
            'less_than',
            'less_than_equal',
            'range'
        )
    );

    /**
     * @var ComparisonHandlerInterface[]
     */
    protected $comparisonOperatorHandlerInstances = array();

    /**
     * @param OperatorInterface $operator
     * @return HandlerInterface
     * @throws \ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException
     */
    public function getHandler(OperatorInterface $operator)
    {
        $name = $operator->getName();
        $type = $operator->getType();

        if (!isset($this->registeredHandlers[$type]) || !in_array($name, $this->registeredHandlers[$type])) {
            throw new InvalidArgumentException(
                'The given operator "' . $name . '" does not have an implemented handler for type ' . $type . '.'
            );
        }

        if ($operator instanceof ComparisonOperatorInterface) {
            return $this->getComparisonOperatorHandlerInstance($operator);
        }

        return null;
    }

    protected function getComparisonOperatorHandlerInstance(ComparisonOperatorInterface $operator)
    {
        if (!isset($this->comparisonOperatorHandlerInstances[$operator->getName()])) {
            $handlerClassName = $this->generateClassNameSpace($operator->getName(), $operator->getType());
            $this->comparisonOperatorHandlerInstances[$operator->getName()] = new $handlerClassName($operator, $this);
        } else {
            $this->comparisonOperatorHandlerInstances[$operator->getName()]->setOperator($operator);
        }
        return $this->comparisonOperatorHandlerInstances[$operator->getName()];
    }

    /**
     * @param $operatorName
     * @param $operatorType
     * @return string
     */
    protected function generateClassNameSpace($operatorName, $operatorType)
    {
        $className = Inflector::camelize($operatorName);
        $handlerNamespace = '\ABK\QueryBundle\Filter\Handler';
        return $handlerNamespace . '\\' . ucfirst($operatorType) . '\\' . ucfirst($className);
    }
}
