<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Record DTO
 *
 * Represents a MARC record with leader and fields
 */
final readonly class Marc
{
    public function __construct(
        public string $leader,
        /** @var array<MarcField> */
        public array $fields = [],
    ) {}

    /**
     * Create a Marc from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $fields = [];
        if (isset($data['fields']) && is_array($data['fields'])) {
            foreach ($data['fields'] as $fieldData) {
                $fields[] = MarcField::fromArray($fieldData);
            }
        }

        return new self(
            leader: $data['leader'],
            fields: $fields,
        );
    }

    /**
     * Convert the Marc to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'leader' => $this->leader,
            'fields' => array_map(fn (MarcField $field): array => $field->toArray(), $this->fields),
        ];
    }

    /**
     * Get control fields (tag < 010)
     *
     * @return array<MarcField>
     */
    public function getControlFields(): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->isControlField());
    }

    /**
     * Get data fields (tag >= 010)
     *
     * @return array<MarcField>
     */
    public function getDataFields(): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->isDataField());
    }

    /**
     * Get fields by tag
     *
     * @return array<MarcField>
     */
    public function getFieldsByTag(string $tag): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->tag === $tag);
    }

    /**
     * Get the first field by tag
     */
    public function getFirstFieldByTag(string $tag): ?MarcField
    {
        $fields = $this->getFieldsByTag($tag);

        $first = array_key_first($fields);
        if ($first === null) {
            return null;
        }

        return $fields[$first];
    }

    /**
     * Get the list of Topical Terms (650 fields)
     *
     * First Indicator:
     * null: no information provided
     * 0: No level specified
     * 1: Primary
     * 2: Secondary
     *
     * Second Indicator:
     * 0 - Library of Congress Subject Headings
     * 1 - Library of Congress Children's and Young Adults' Subject Headings
     * 2 - Medical Subject Headings
     * 3 - National Agricultural Library subject authority file
     * 4 - Source not specified
     * 5 - Canadian Subject Headings
     * 6 - Répertoire de vedettes-matière
     * 7 - Source specified in subfield $2
     *
     * @return array<MarcField>
     */
    public function getTopicalTerms(?int $firstIndicator = null, ?int $secondIndicator = null): array
    {

        return array_filter($this->fields, function (MarcField $field) use ($firstIndicator, $secondIndicator): bool {
            if ($field->tag !== '650') {
                return false;
            }

            if ($firstIndicator !== null && $field->data->ind1 !== (string) $firstIndicator) {
                return false;
            }

            if ($secondIndicator !== null && $field->data->ind2 !== (string) $secondIndicator) {
                return false;
            }

            return true;
        });

    }
}
