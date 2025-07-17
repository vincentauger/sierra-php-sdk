<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Represents a Sierra API query field
 */
final readonly class Field
{
    public function __construct(
        public ?string $tag = null,
        public ?string $marcTag = null,
        public ?string $ind1 = null,
        public ?string $ind2 = null,
        public ?string $subfields = null,
    ) {}

    /**
     * Convert the field to an array for JSON serialization
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->tag !== null) {
            $result['tag'] = $this->tag;
        }

        if ($this->marcTag !== null) {
            $result['marcTag'] = $this->marcTag;
        }

        if ($this->ind1 !== null) {
            $result['ind1'] = $this->ind1;
        }

        if ($this->ind2 !== null) {
            $result['ind2'] = $this->ind2;
        }

        if ($this->subfields !== null) {
            $result['subfields'] = $this->subfields;
        }

        return $result;
    }
}
