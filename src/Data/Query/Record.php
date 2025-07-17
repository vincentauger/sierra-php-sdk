<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Represents a Sierra API query record target
 */
final readonly class Record
{
    public function __construct(
        public string $type,
        public ?string $relationType = null,
        public ?string $relationTag = null,
    ) {}

    /**
     * Convert the record to an array for JSON serialization
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = ['type' => $this->type];

        if ($this->relationType !== null) {
            $result['relationType'] = $this->relationType;
        }

        if ($this->relationTag !== null) {
            $result['relationTag'] = $this->relationTag;
        }

        return $result;
    }
}
