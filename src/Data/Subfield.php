<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Subfield DTO
 *
 * Represents a MARC subfield within a variable field
 */
final readonly class Subfield
{
    public function __construct(
        public string $tag,
        public string $content,
    ) {}

    /**
     * Create a Subfield from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            tag: $data['tag'],
            content: $data['content'],
        );
    }

    /**
     * Convert the Subfield to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'tag' => $this->tag,
            'content' => $this->content,
        ];
    }
}
