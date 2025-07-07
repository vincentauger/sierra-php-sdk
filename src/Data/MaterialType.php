<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Material Type DTO
 *
 * Represents a material type code and display name
 */
final readonly class MaterialType
{
    public function __construct(
        public string $code,
        public ?string $value = null,
    ) {}

    /**
     * Create a MaterialType from Sierra API response data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            value: $data['value'] ?? null,
        );
    }

    /**
     * Convert the MaterialType to an array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'value' => $this->value,
        ];
    }

    /**
     * Get the display value or fallback to code
     */
    public function getDisplayValue(): string
    {
        return $this->value ?? $this->code;
    }
}
