<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Field DTO
 *
 * Represents a MARC field with tag and either value (control fields) or data (data fields)
 */
final readonly class MarcField
{
    public function __construct(
        public string $tag,
        public ?string $value = null,
        public ?FieldData $data = null,
    ) {}

    /**
     * Create a MarcField from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $fieldData = null;
        if (isset($data['data']) && is_array($data['data'])) {
            $fieldData = FieldData::fromArray($data['data']);
        }

        return new self(
            tag: $data['tag'],
            value: $data['value'] ?? null,
            data: $fieldData,
        );
    }

    /**
     * Convert the MarcField to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'tag' => $this->tag,
        ];

        if ($this->value !== null) {
            $result['value'] = $this->value;
        }

        if ($this->data instanceof \VincentAuger\SierraSdk\Data\FieldData) {
            $result['data'] = $this->data->toArray();
        }

        return $result;
    }

    /**
     * Check if this is a control field (tag < 010)
     */
    public function isControlField(): bool
    {
        return intval($this->tag) < 10;
    }

    /**
     * Check if this is a data field (tag >= 010)
     */
    public function isDataField(): bool
    {
        return ! $this->isControlField();
    }
}
