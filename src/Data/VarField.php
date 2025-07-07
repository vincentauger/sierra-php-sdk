<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Variable Field DTO
 *
 * Represents a MARC variable field (tags 010-999)
 */
final readonly class VarField
{
    public function __construct(
        public string $fieldTag,
        public ?string $marcTag = null,
        public ?string $ind1 = null,
        public ?string $ind2 = null,
        public ?string $content = null,
        /** @var Subfield[]|null */
        public ?array $subfields = null,
    ) {}

    /**
     * Create a VarField from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            fieldTag: $data['fieldTag'],
            marcTag: $data['marcTag'] ?? null,
            ind1: $data['ind1'] ?? null,
            ind2: $data['ind2'] ?? null,
            content: $data['content'] ?? null,
            subfields: isset($data['subfields']) ? array_map(
                fn (array $subfield): \VincentAuger\SierraSdk\Data\Subfield => Subfield::fromArray($subfield),
                $data['subfields']
            ) : null,
        );
    }

    /**
     * Convert the VarField to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'fieldTag' => $this->fieldTag,
            'marcTag' => $this->marcTag,
            'ind1' => $this->ind1,
            'ind2' => $this->ind2,
            'content' => $this->content,
            'subfields' => $this->subfields !== null && $this->subfields !== [] ? array_map(
                fn (Subfield $subfield): array => $subfield->toArray(),
                $this->subfields
            ) : null,
        ];
    }

    /**
     * Get the complete field content as a string
     */
    public function getContentString(): string
    {
        if ($this->content !== null) {
            return $this->content;
        }

        if ($this->subfields === null) {
            return '';
        }

        return implode(' ', array_map(
            fn (Subfield $subfield): string => $subfield->content,
            $this->subfields
        ));
    }

    /**
     * Get subfield by code
     */
    public function getSubfield(string $code): ?Subfield
    {
        if ($this->subfields === null) {
            return null;
        }

        foreach ($this->subfields as $subfield) {
            if ($subfield->tag === $code) {
                return $subfield;
            }
        }

        return null;
    }

    /**
     * Get all subfields with a specific code
     *
     * @return Subfield[] Array of subfields matching the code
     */
    public function getSubfields(string $code): array
    {
        if ($this->subfields === null) {
            return [];
        }

        return array_filter(
            $this->subfields,
            fn (Subfield $subfield): bool => $subfield->tag === $code
        );
    }
}
