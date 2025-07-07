<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Location DTO
 *
 * Represents a location/library branch
 */
final readonly class Location
{
    public function __construct(
        public string $code,
        public string $name,
    ) {
    }

    /**
     * Create a Location from Sierra API response data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
        );
    }

    /**
     * Convert the Location to an array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
        ];
    }
}
