<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Bib Search Result Entry DTO
 *
 * Represents a single search result entry with relevance score and bib data
 */
final readonly class BibSearchResultEntry
{
    public function __construct(
        public string|float $relevance,
        public BibObject $bib,
    ) {}

    /**
     * Create a BibSearchResultEntry from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            relevance: $data['relevance'],
            bib: BibObject::fromArray($data['bib']),
        );
    }

    /**
     * Convert the BibSearchResultEntry to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'relevance' => $this->relevance,
            'bib' => $this->bib->toArray(),
        ];
    }
}
