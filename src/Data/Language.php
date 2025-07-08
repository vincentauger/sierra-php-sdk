<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Language DTO
 *
 * Represents a language code and display name
 */
final readonly class Language
{
    public function __construct(
        public string $code,
        public ?string $name = null,
    ) {}

    /**
     * Create a Lang from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'] ?? null,
        );
    }

    /**
     * Convert the Lang to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
        ];
    }

    /**
     * Get the display name or fallback to code
     */
    public function getDisplayName(): string
    {
        return $this->name ?? $this->code;
    }
}
