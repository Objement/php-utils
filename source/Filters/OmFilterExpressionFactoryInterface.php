<?php

namespace Objement\OmPhpUtils\Filters;

use Objement\OmPhpUtils\Filters\FilterExpressions\OmBetweenFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEndsWithFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmEqualsFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmGreaterThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLikeFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmLowerThanFilterExpressionCondition;
use Objement\OmPhpUtils\Filters\FilterExpressions\OmStartsWithFilterExpressionCondition;

interface OmFilterExpressionFactoryInterface
{
    public static function equals(string $name, $value): OmEqualsFilterExpressionCondition;

    public static function between(string $name, $min, $max): OmBetweenFilterExpressionCondition;

    public static function startsWith(string $name, $value): OmStartsWithFilterExpressionCondition;

    public static function like(string $name, $value): OmLikeFilterExpressionCondition;

    public static function endsWith(string $name, $value): OmEndsWithFilterExpressionCondition;

    public static function greaterThan(string $name, float $value): OmGreaterThanFilterExpressionCondition;

    public static function lowerThan(string $name, float $value): OmLowerThanFilterExpressionCondition;
}
