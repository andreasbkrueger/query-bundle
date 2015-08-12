<?php

namespace ABK\QueryBundle\Filter;

interface FieldMapperInterface
{
    /**
     * @param string $field
     * @return string
     */
    public function map($field);
}
