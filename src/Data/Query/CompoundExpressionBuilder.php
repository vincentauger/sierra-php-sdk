<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Builder for creating compound Sierra API query expressions
 */
final class CompoundExpressionBuilder
{
    public function __construct(
        private Target $target,
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
        // For now, we'll build the expressions manually
        // In a full implementation, you'd need to properly handle the compound expression building
        // This is a simplified version for demonstration
        return new Query($this->target);
    }
}
