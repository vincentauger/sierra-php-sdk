<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Query Entry DTO
 *
 * Represents a single query result entry with a link to the resulting record
 */
final readonly class QueryEntry
{
    public function __construct(
        public string $link,
    ) {}

    /**
     * Get the record ID from the link
     */
    public function getId(): int
    {
        // Extract the ID from the link
        $parts = explode('/', $this->link);

        return (int) end($parts); // Return the last part as the ID
    }

    /**
     * Create a QueryEntry from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            link: $data['link'],
        );
    }

    /**
     * Convert the QueryEntry to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'link' => $this->link,
        ];
    }
}
