<?php
/**
 * @author: Andreas Krueger
 */

namespace ABK\QueryBundle\Filter\Operators;

use ABK\QueryBundle\Filter\Filter;

interface OperatorInterface
{
    public function getType();

    public function getName();

    public function setParent(Filter $parent);

    public function getParent();
}
