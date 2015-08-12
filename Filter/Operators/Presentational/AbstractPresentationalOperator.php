<?php

namespace ABK\QueryBundle\Filter\Operators\Presentational;

use ABK\QueryBundle\Filter\Operators\AbstractOperator;
use ABK\QueryBundle\Filter\Operators\Types;

abstract class AbstractPresentationalOperator extends AbstractOperator
{
    protected function setType()
    {
        $this->type = Types::PRESENTATIONAL;
    }
}
