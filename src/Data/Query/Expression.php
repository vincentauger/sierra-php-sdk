<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Represents a Sierra API query expression
 */
final readonly class Expression
{
    public function __construct(
        public ?string $op = null,
        public ?array $operands = null,
        public ?array $expressions = null,
    ) {}

    /**
     * Convert the expression to an array for JSON serialization
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        if ($this->expressions !== null) {
            // Compound expression
            $expressions = [];
            foreach ($this->expressions as $item) {
                if ($item instanceof self) {
                    $expressions[] = $item->toArray();
                } elseif (is_string($item)) {
                    $expressions[] = $item; // AND/OR operator
                }
            }
            return $expressions;
        }

        // Simple expression
        $result = [];
        if ($this->op !== null) {
            $result['op'] = $this->op;
        }
        if ($this->operands !== null) {
            $result['operands'] = $this->operands;
        }

        return $result;
    }
}
