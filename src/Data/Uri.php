<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API URI DTO
 *
 * Represents a URI/URL associated with a bib record
 */
final readonly class Uri
{
    public function __construct(
        public string $url,
        public ?string $label = null,
        public ?string $note = null,
    ) {}

    /**
     * Create a Uri from Sierra API response data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['url'],
            label: $data['label'] ?? null,
            note: $data['note'] ?? null,
        );
    }

    /**
     * Convert the Uri to an array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'label' => $this->label,
            'note' => $this->note,
        ];
    }
}
