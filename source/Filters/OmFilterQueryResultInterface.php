<?php

namespace Objement\OmPhpUtils\Filters;

interface OmFilterQueryResultInterface
{
    function getTotalCount(): int;

    function getResults(): array;

    function getFilterQuery(): ?OmFilterQueryInterface;
}
