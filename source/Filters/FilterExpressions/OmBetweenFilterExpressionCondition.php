<?php

namespace Objement\OmPhpUtils\Filters\FilterExpressions;

class OmBetweenFilterExpressionCondition extends OmFilterExpressionConditionBase
{
    private mixed $max;
    private mixed $min;

    public function __construct(string $name, mixed $min, mixed $max)
    {
        parent::__construct($name, [$min, $max]);
        $this->min = $this->value;
        $this->max = $max;
    }

    /**
     * @return mixed
     */
    public function getMax(): mixed
    {
        return $this->max;
    }

    /**
     * @return mixed
     */
    public function getMin(): mixed
    {
        return $this->min;
    }
}
