<?php

namespace Objement\OmPhpUtils\Filters;

use Exception;
use Objement\OmPhpUtils\Exceptions\OmFilterQuerySqlAdapterFilterGroupExpressionMissingException;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmAndFilterExpressionGroup;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmBetweenFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEndsWithFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEqualsFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmFilterExpressionGroupInterface;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmFilterExpressionInterface;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmGreaterThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLikeFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLowerThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmOrFilterExpressionGroup;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmStartsWithFilterExpressionCondition;
use PDO;

class OmFilterQuerySqlAdapter implements OmFilterQuerySqlAdapterInterface
{
    private OmFilterQueryInterface $filterQuery;
    private PDO $connection;

    public function __construct(OmFilterQueryInterface $filterQuery, PDO $connection)
    {
        $this->filterQuery = $filterQuery;
        $this->connection = $connection;
    }

    /**
     * @param string $sqlQueryPattern Use placeholders {where}, {order}, {limit}
     * @return array|string
     * @throws Exception
     */
    public function getSqlQuery(string $sqlQueryPattern): array|string
    {
        $placeholders = [
            'where' => $this->extractWhereClause(),
            'order' => $this->extractOrderClause(),
            'limit' => $this->extractLimitClause()
        ];

        return str_replace(array_map(fn($v) => '{' . $v . '}', array_keys($placeholders)), array_values($placeholders), $sqlQueryPattern);
    }

    /**
     * @throws Exception
     */
    private function extractWhereClause(): string
    {
        if (empty($this->filterQuery->getExpressions())) {
            return '1=1';
        }

        $expressions = $this->filterQuery->getExpressions();
        $rootExpression = count($expressions) == 1 && $expressions[0] instanceof OmFilterExpressionGroupInterface
            ? $expressions[0]
            : new OmAndFilterExpressionGroup($expressions);

        $clause = $this->getWhereClauseForExpression($rootExpression);
        // remove brackets at start and end when existent
        if ($clause[0] === '(' && isset($clause[strlen($clause) - 1]) && $clause[strlen($clause) - 1] === ')') {
            $clause = substr($clause, 1, strlen($clause) - 2);
        }

        return $clause;
    }

    /**
     * @param OmFilterExpressionInterface $filterExpression
     * @return string
     * @throws Exception
     */
    private function getWhereClauseForExpression(OmFilterExpressionInterface $filterExpression): string
    {
        if ($filterExpression instanceof OmFilterExpressionGroupInterface) {
            if ($filterExpression instanceof OmAndFilterExpressionGroup) {
                $groupOperator = 'AND';
            } elseif ($filterExpression instanceof OmOrFilterExpressionGroup) {
                $groupOperator = 'OR';
            } else {
                throw new OmFilterQuerySqlAdapterFilterGroupExpressionMissingException("Implementation for FilterGroupExpression is missing. " . $filterExpression::class);
            }

            $conditionSqls = array_values(array_map(fn($expr) => $this->getWhereClauseForExpression($expr), $filterExpression->getExpressions()));

            return '(' . implode(' ' . $groupOperator . ' ', empty($conditionSqls) ? ['1=1'] : $conditionSqls) . ')';
        } else {
            if ($filterExpression instanceof OmEqualsFilterExpressionCondition) {
                return sprintf("`%s`=%s", $this->getExpressionName($filterExpression->getName()), $this->connection->quote($filterExpression->getValue() ?? ''));
            } elseif ($filterExpression instanceof OmLikeFilterExpressionCondition) {
                return sprintf("`%s` LIKE %s", $this->getExpressionName($filterExpression->getName()), $this->connection->quote("%" . $this->escapeLikeValue($filterExpression->getValue() ?? '') . "%"));
            } elseif ($filterExpression instanceof OmBetweenFilterExpressionCondition && $filterExpression->getValue() !== null && isset($filterExpression->getValue()[0]) && isset($filterExpression->getValue()[1])) {
                return sprintf("`%s` BETWEEN %s AND %s", $this->getExpressionName($filterExpression->getName()), $this->connection->quote($filterExpression->getValue()[0]), $this->connection->quote($filterExpression->getValue()[1]));
            } elseif ($filterExpression instanceof OmEndsWithFilterExpressionCondition) {
                return sprintf("`%s` LIKE %s", $this->getExpressionName($filterExpression->getName()), $this->connection->quote("%" . $this->escapeLikeValue($filterExpression->getValue() ?? '')));
            } elseif ($filterExpression instanceof OmStartsWithFilterExpressionCondition) {
                return sprintf("`%s` LIKE %s", $this->getExpressionName($filterExpression->getName()), $this->connection->quote($this->escapeLikeValue($filterExpression->getValue() ?? '') . "%"));
            } elseif ($filterExpression instanceof OmGreaterThanFilterExpressionCondition) {
                return sprintf("`%s`>%F", $this->getExpressionName($filterExpression->getName()), $this->connection->quote($filterExpression->getValue()));
            } elseif ($filterExpression instanceof OmLowerThanFilterExpressionCondition) {
                return sprintf("`%s`<%F", $this->getExpressionName($filterExpression->getName()), $this->connection->quote($filterExpression->getValue()));
            } else {
                throw new OmFilterQuerySqlAdapterFilterGroupExpressionMissingException("Implementation for FilterExpression is missing. " . $filterExpression::class);
            }
        }
    }

    private function getExpressionName(string $name): string
    {
        if ($this->filterQuery->getDatabaseNameMappings()) {
            $mappings = $this->filterQuery->getDatabaseNameMappings();
            if (isset($mappings[$name])) {
                return $mappings[$name];
            }
        }

        return $name;
    }

    private function escapeLikeValue(string $value): string
    {
        return str_replace(['\\', '_', '%'], ['\\\\', '\\_', '\\%'], $value);
    }

    private function extractOrderClause(): string
    {
        if (!$this->filterQuery->getSorting()) {
            return '';
        }

        return 'ORDER BY ' . implode(', ', array_map(fn($sorting) => sprintf("`%s` %s", $sorting->getName(), $sorting->getDirection()), $this->filterQuery->getSorting()));
    }

    private function extractLimitClause(): string
    {
        if (!$this->filterQuery->getLimit()) {
            return '';
        }

        if ($this->filterQuery->getLimit()->getStart()) {
            return 'LIMIT ' . $this->filterQuery->getLimit()->getStart() . ', ' . $this->filterQuery->getLimit()->getLength();
        }

        return 'LIMIT ' . $this->filterQuery->getLimit()->getLength();
    }
}
