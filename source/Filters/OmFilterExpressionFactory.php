<?php

namespace Objement\OmPhpUtils\Filters;

use Objement\OmPhpUtils\Filters\FilterExpressions\OmBetweenFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEndsWithFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEqualsFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmGreaterThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLikeFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLowerThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmStartsWithFilterExpressionCondition;

class OmFilterExpressionFactory implements OmFilterExpressionFactoryInterface
{
    public static function equals(string $name, $value): OmEqualsFilterExpressionCondition
    {
        return new OmEqualsFilterExpressionCondition($name, $value);
    }

    public static function like(string $name, $value): OmLikeFilterExpressionCondition
    {
        return new OmLikeFilterExpressionCondition($name, $value);
    }

    public static function startsWith(string $name, $value): OmStartsWithFilterExpressionCondition
    {
        return new OmStartsWithFilterExpressionCondition($name, $value);
    }

    public static function endsWith(string $name, $value): OmEndsWithFilterExpressionCondition
    {
        return new OmEndsWithFilterExpressionCondition($name, $value);
    }

    public static function between(string $name, $min, $max): OmBetweenFilterExpressionCondition
    {
        return new OmBetweenFilterExpressionCondition($name, $min, $max);
    }

    public static function greaterThan(string $name, float $value): OmGreaterThanFilterExpressionCondition
    {
        return new OmGreaterThanFilterExpressionCondition($name, $value);
    }

    public static function lowerThan(string $name, float $value): OmLowerThanFilterExpressionCondition
    {
        return new OmLowerThanFilterExpressionCondition($name, $value);
    }
}
