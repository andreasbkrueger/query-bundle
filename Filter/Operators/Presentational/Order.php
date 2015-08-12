<?php

namespace ABK\QueryBundle\Filter\Operators\Presentational;

use ABK\QueryBundle\Filter\Exceptions\InvalidArgumentException;
use ABK\QueryBundle\Filter\Operators\Names;

class Order extends AbstractPresentationalOperator
{
    const ASC = 'asc';
    const DESC = 'desc';

    /**
     * @var string
     */
    protected $field;
    protected $direction;

    public function __construct($field, $direction = self::ASC)
    {
        if (!in_array($direction, array(self::ASC, self::DESC))) {
            throw new InvalidArgumentException('The given argument ' . $direction . ' is not a valid direction.');
        }

        $this->field = $field;
        $this->direction = $direction;
        parent::__construct();
    }

    protected function setName()
    {
        $this->name = Names::ORDER;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
