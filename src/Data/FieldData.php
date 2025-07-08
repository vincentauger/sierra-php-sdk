<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Field Data DTO
 *
 * Represents MARC field data with subfields and indicators
 */
final readonly class FieldData
{
    public function __construct(
        /** @var array<MarcSubField> */
        public array $subfields,
        public string $ind1,
        public string $ind2,
    ) {}

    /**
     * Create a FieldData from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $subfields = [];
        if (isset($data['subfields']) && is_array($data['subfields'])) {
            foreach ($data['subfields'] as $subfieldData) {
                $subfields[] = MarcSubField::fromArray($subfieldData);
            }
        }

        return new self(
            subfields: $subfields,
            ind1: $data['ind1'] ?? ' ',
            ind2: $data['ind2'] ?? ' ',
        );
    }

    /**
     * Convert the FieldData to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'subfields' => array_map(fn (MarcSubField $subfield): array => $subfield->toArray(), $this->subfields),
            'ind1' => $this->ind1,
            'ind2' => $this->ind2,
        ];
    }
}
