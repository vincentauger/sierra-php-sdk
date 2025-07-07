<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Fixed Field DTO
 *
 * Represents a MARC fixed field (leader, control fields 001-009)
 */
final readonly class FixedField
{
    public function __construct(
        public string $label,
        public string $value,
        public ?string $display = null,
    ) {}

    /**
     * Create a FixedField from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            label: $data['label'],
            value: $data['value'],
            display: $data['display'] ?? null,
        );
    }

    /**
     * Convert the FixedField to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'display' => $this->display,
        ];
    }
}
