<?php

namespace ABK\QueryBundle\Filter\Operators\Structure;

use ABK\QueryBundle\Filter\Operators\AbstractOperator;
use ABK\QueryBundle\Filter\Operators\Types;

abstract class AbstractStructureOperator extends AbstractOperator
{
    protected function setType()
    {
        $this->type = Types::STRUCTURE;
    }
}
