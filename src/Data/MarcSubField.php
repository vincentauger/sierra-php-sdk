<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Subfield DTO
 *
 * Represents a MARC subfield with code and data
 */
final readonly class MarcSubField
{
    public function __construct(
        public string $code,
        public string $data,
    ) {}

    /**
     * Create a MarcSubField from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        // The data structure is: [code => data]
        // e.g., ["a" => "Beaudry-Sylvestre, Manuelle."]
        $code = (string) array_key_first($data);
        $subfieldData = $data[$code];

        return new self(
            code: $code,
            data: (string) $subfieldData,
        );
    }

    /**
     * Convert the MarcSubField to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            $this->code => $this->data,
        ];
    }
}
