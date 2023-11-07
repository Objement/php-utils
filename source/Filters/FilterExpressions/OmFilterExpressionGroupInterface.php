<?php

namespace Objement\OmPhpUtils\Filters\FilterExpressions;

interface OmFilterExpressionGroupInterface extends OmFilterExpressionInterface
{

    /**
     * @return OmFilterExpressionInterface[]|null
     */
    public function getExpressions(): ?array;
}
