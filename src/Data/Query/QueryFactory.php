<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Factory for creating Sierra API queries with a fluent interface
 */
final class QueryFactory
{
    /**
     * Create a new simple query for bibliographic records
     */
    public static function bib(): TargetBuilder
    {
        return new TargetBuilder(new Record('bib'));
    }

    /**
     * Create a new simple query for item records
     */
    public static function item(): TargetBuilder
    {
        return new TargetBuilder(new Record('item'));
    }

    /**
     * Create a new simple query for patron records
     */
    public static function patron(): TargetBuilder
    {
        return new TargetBuilder(new Record('patron'));
    }

    /**
     * Create a new simple query for order records
     */
    public static function order(): TargetBuilder
    {
        return new TargetBuilder(new Record('order'));
    }

    /**
     * Create a new simple query for authority records
     */
    public static function authority(): TargetBuilder
    {
        return new TargetBuilder(new Record('authority'));
    }

    /**
     * Create a new simple query for holdings records
     */
    public static function holdings(): TargetBuilder
    {
        return new TargetBuilder(new Record('holdings'));
    }

    /**
     * Create a compound query with AND logic
     */
    public static function and(Query ...$queries): Query
    {
        $queryArray = [];
        foreach ($queries as $i => $query) {
            $queryArray[] = $query;
            if ($i < count($queries) - 1) {
                $queryArray[] = 'AND';
            }
        }

        return new Query(queries: $queryArray);
    }

    /**
     * Create a compound query with OR logic
     */
    public static function or(Query ...$queries): Query
    {
        $queryArray = [];
        foreach ($queries as $i => $query) {
            $queryArray[] = $query;
            if ($i < count($queries) - 1) {
                $queryArray[] = 'OR';
            }
        }

        return new Query(queries: $queryArray);
    }

    /**
     * Create a custom record type query
     */
    public static function recordType(string $type): TargetBuilder
    {
        return new TargetBuilder(new Record($type));
    }
}
