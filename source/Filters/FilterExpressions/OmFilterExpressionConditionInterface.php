<?php

namespace Objement\OmPhpUtils\Filters\FilterExpressions;

interface OmFilterExpressionConditionInterface extends OmFilterExpressionInterface
{
    /**
     * @return mixed|null
     */
    public function getValue(): mixed;

    /**
     * @return string
     */
    public function getName(): string;
}
