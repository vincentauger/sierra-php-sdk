<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Builder for creating compound Sierra API query expressions
 */
final class CompoundExpressionBuilder
{
    /**
     * @param  array<ExpressionBuilder|string>  $expressions
     */
    public function __construct(
        private array $expressions,
    ) {}

    /**
     * Add another expression with AND logic
     */
    public function and(ExpressionBuilder $expression): self
    {
        $this->expressions[] = 'AND';
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * Add another expression with OR logic
     */
    public function or(ExpressionBuilder $expression): self
    {
        $this->expressions[] = 'OR';
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * Build the final query with compound expression
     */
    public function build(): Query
    {
        // Since expressions are stored as a flat array with operators,
        // we pass them directly to the Query constructor
        return new Query(queries: $this->expressions);
    }
}
