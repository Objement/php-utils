<?php

namespace Objement\OmPhpUtils\Filters\FilterExpressions;

abstract class OmFilterExpressionConditionBase implements OmFilterExpressionConditionInterface
{
    protected string $name;
    protected mixed $value;

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
