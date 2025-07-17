<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Represents a Sierra API query structure
 */
final readonly class Query
{
    /**
     * @param  array<Query|string>|null  $queries
     */
    public function __construct(
        public ?Target $target = null,
        public ?Expression $expr = null,
        public ?array $queries = null,
    ) {}

    /**
     * Convert the query to an array for JSON serialization
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        if ($this->queries !== null) {
            // Compound query
            $queries = [];
            foreach ($this->queries as $item) {
                if ($item instanceof self) {
                    $queries[] = $item->toArray();
                } elseif (is_string($item)) {
                    $queries[] = $item; // AND/OR operator
                }
            }

            return ['queries' => $queries];
        }

        // Simple query
        $result = [];
        if ($this->target instanceof \VincentAuger\SierraSdk\Data\Query\Target) {
            $result['target'] = $this->target->toArray();
        }
        if ($this->expr instanceof \VincentAuger\SierraSdk\Data\Query\Expression) {
            $result['expr'] = $this->expr->toArray();
        }

        return $result;
    }
}
