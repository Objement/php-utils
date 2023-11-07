<?php

namespace Objement\OmPhpUtils\Filters;


use Objement\OmPhpUtils\Filters\FilterExpressions\OmFilterExpressionInterface;

interface OmFilterQueryInterface
{

    /**
     * @return OmFilterExpressionInterface[]
     */
    public function getExpressions(): array;

    /**
     * @return OmQueryLimit|null
     */
    public function getLimit(): ?OmQueryLimit;

    /**
     * @return OmQuerySorting[]|null
     */
    public function getSorting(): ?array;

    /**
     * @param OmQueryLimit $limit
     * @return OmFilterQuery
     */
    public function setLimit(OmQueryLimit $limit): OmFilterQuery;

    /**
     * @param OmFilterExpressionInterface[] $expressions
     * @return OmFilterQuery
     */
    public function setExpressions(array $expressions): OmFilterQuery;

    /**
     * @param OmQuerySorting[] $sorting
     * @return OmFilterQuery
     */
    public function setSorting(array $sorting): OmFilterQuery;

    /**
     * Should return the database names for model property names (when necessary)
     * @return array|null
     */
    public function getDatabaseNameMappings(): ?array;

    /**
     * Set the names of the database columns for the model property names. E.g. Customer->get"fullName" (MODEL) to "full_name" (DATABASE)
     * @param array|null $mappingToDatabaseName
     * @return OmFilterQueryInterface
     */
    public function setDatabaseNameMappings(?array $mappingToDatabaseName): self;
}
