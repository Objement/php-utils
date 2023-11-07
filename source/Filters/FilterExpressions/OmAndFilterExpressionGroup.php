<?php

namespace Objement\OmPhpUtils\Filters\FilterExpressions;

class OmAndFilterExpressionGroup implements OmFilterExpressionGroupInterface
{
    private array $expressions;

    /**
     * @param OmFilterExpressionInterface[] $expressions
     */
    public function __construct(array $expressions)
    {
        $this->expressions = $expressions;
    }

    public function getExpressions(): ?array
    {
        return $this->expressions;
    }
}
