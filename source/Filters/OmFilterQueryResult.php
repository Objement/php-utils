<?php

namespace Objement\OmPhpUtils\Filters;

class OmFilterQueryResult implements OmFilterQueryResultInterface
{
    private int $totalCount;
    private array $results;
    private ?OmFilterQueryInterface $filterQuery;

    /**
     * @param int $totalCount
     * @param array $results
     * @param OmFilterQueryInterface|null $filterQuery
     */
    public function __construct(int $totalCount, array $results, ?OmFilterQueryInterface $filterQuery = null)
    {
        $this->totalCount = $totalCount;
        $this->results = $results;
        $this->filterQuery = $filterQuery;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function getFilterQuery(): ?OmFilterQueryInterface
    {
        return $this->filterQuery;
    }
}
