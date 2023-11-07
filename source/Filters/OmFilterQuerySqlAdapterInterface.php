<?php

namespace Objement\OmPhpUtils\Filters;

interface OmFilterQuerySqlAdapterInterface
{
    /**
     * @param string $sqlQueryPattern
     */
    public function getSqlQuery(string $sqlQueryPattern);
}
