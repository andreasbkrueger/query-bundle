<?php
namespace ABK\QueryBundle\Filter\Handler;

use ABK\QueryBundle\Filter\Operators\OperatorInterface;

interface HandlerInterface
{
    public function doesMatch($value);
}
