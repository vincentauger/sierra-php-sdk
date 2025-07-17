<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Builder for creating Sierra API query expressions with a fluent interface
 */
final readonly class ExpressionBuilder
{
    public function __construct(
        private Target $target,
    ) {}

    /**
     * Create a query with an "equals" expression
     */
    public function equals(string ...$values): Query
    {
        $expression = new Expression(
            op: 'equals',
            operands: array_values($values)
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "has" expression
     */
    public function has(string ...$values): Query
    {
        $expression = new Expression(
            op: 'has',
            operands: array_values($values)
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "range" expression
     */
    public function range(string $from, string $to): Query
    {
        $expression = new Expression(
            op: 'range',
            operands: [$from, $to]
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "greater" expression
     */
    public function greater(string $value): Query
    {
        $expression = new Expression(
            op: 'greater',
            operands: [$value]
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "less" expression
     */
    public function less(string $value): Query
    {
        $expression = new Expression(
            op: 'less',
            operands: [$value]
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "between" expression
     */
    public function between(string $from, string $to): Query
    {
        $expression = new Expression(
            op: 'between',
            operands: [$from, $to]
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with a "starts_with" expression
     */
    public function startsWith(string $value): Query
    {
        $expression = new Expression(
            op: 'starts_with',
            operands: [$value]
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a query with an "empty" expression
     */
    public function empty(): Query
    {
        $expression = new Expression(
            op: 'empty',
            operands: []
        );

        return new Query($this->target, $expression);
    }

    /**
     * Create a compound expression with AND logic
     */
    public function and(ExpressionBuilder $other): CompoundExpressionBuilder
    {
        return new CompoundExpressionBuilder([$this, 'AND', $other]);
    }

    /**
     * Create a compound expression with OR logic
     */
    public function or(ExpressionBuilder $other): CompoundExpressionBuilder
    {
        return new CompoundExpressionBuilder([$this, 'OR', $other]);
    }

    /**
     * Get the current target
     */
    public function getTarget(): Target
    {
        return $this->target;
    }
}
