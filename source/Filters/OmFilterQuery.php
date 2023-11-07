<?php

namespace Objement\OmPhpUtils\Filters;


use Objement\OmPhpUtils\Filters\FilterExpressions\OmFilterExpressionInterface;

class OmFilterQuery implements OmFilterQueryInterface
{
    private ?OmQueryLimit $limit = null;
    /**
     * @var OmFilterExpressionInterface[]
     */
    private array $expressions = [];
    /**
     * @var OmQuerySorting[]|null
     */
    private ?array $sorting = null;
    /**
     * @var array|null
     */
    private ?array $databaseNameMappings = null;

    /**
     * @return OmFilterExpressionInterface[]
     */
    public function getExpressions(): array
    {
        return $this->expressions;
    }

    /**
     * @param OmFilterExpressionInterface[] $expressions
     * @return OmFilterQuery
     */
    public function setExpressions(array $expressions): OmFilterQuery
    {
        $this->expressions = $expressions;
        return $this;
    }

    /**
     * @return OmQuerySorting[]|null
     */
    public function getSorting(): ?array
    {
        return $this->sorting;
    }

    /**
     * @param OmQuerySorting[] $sorting
     * @return OmFilterQuery
     */
    public function setSorting(array $sorting): OmFilterQuery
    {
        $this->sorting = $sorting;
        return $this;
    }

    /**
     * @return OmQueryLimit|null
     */
    public function getLimit(): ?OmQueryLimit
    {
        return $this->limit;
    }

    /**
     * @param OmQueryLimit $limit
     * @return OmFilterQuery
     */
    public function setLimit(OmQueryLimit $limit): OmFilterQuery
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDatabaseNameMappings(): ?array
    {
        return $this->databaseNameMappings;
    }

    /**
     * @inheritDoc
     */
    public function setDatabaseNameMappings(?array $mappingToDatabaseName): OmFilterQueryInterface
    {
        $this->databaseNameMappings = $mappingToDatabaseName;
        return $this;
    }
}
