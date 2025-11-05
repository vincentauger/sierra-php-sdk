<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

use DateTimeImmutable;

/**
 * Sierra API Bib Object DTO
 *
 * Represents a bibliographic record from the Sierra ILS API
 *
 * @see https://techdocs.iii.com/sierraapi/Content/zObjects/bibObjectDescription.htm
 */
final readonly class BibObject
{
    public function __construct(
        public int|string $id,
        public ?DateTimeImmutable $updatedDate = null,
        public ?DateTimeImmutable $createdDate = null,
        public ?DateTimeImmutable $deletedDate = null,
        public ?bool $deleted = null,
        public ?bool $suppressed = null,
        public ?string $available = null,
        public ?string $isbn = null,
        public ?string $issn = null,
        public ?string $upc = null,
        public ?Language $lang = null,
        public ?string $title = null,
        public ?string $author = null,
        public ?Marc $marc = null,
        public ?MaterialType $materialType = null,
        public ?BibLevel $bibLevel = null,
        public ?int $publishYear = null,
        public ?string $catalogDate = null,
        public ?Country $country = null,
        /** @var OrderInfo[]|null */
        public ?array $orders = null,
        public ?string $normTitle = null,
        public ?string $normAuthor = null,
        /** @var Location[]|null */
        public ?array $locations = null,
        public ?int $holdCount = null,
        public ?int $copies = null,
        public ?string $callNumber = null,
        /** @var array<string>|null */
        public ?array $volumes = null,
        /** @var array<string>|null */
        public ?array $items = null,
        /** @var FixedField[]|null */
        public ?array $fixedFields = null,
        /** @var VarField[]|null */
        public ?array $varFields = null,
    ) {}

    /**
     * Create a BibObject from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            updatedDate: isset($data['updatedDate']) ? new DateTimeImmutable($data['updatedDate']) : null,
            createdDate: isset($data['createdDate']) ? new DateTimeImmutable($data['createdDate']) : null,
            deletedDate: isset($data['deletedDate']) ? new DateTimeImmutable($data['deletedDate']) : null,
            deleted: $data['deleted'] ?? null,
            suppressed: $data['suppressed'] ?? null,
            available: $data['available'] ?? null,
            isbn: $data['isbn'] ?? null,
            issn: $data['issn'] ?? null,
            upc: $data['upc'] ?? null,
            lang: isset($data['lang']) ? Language::fromArray($data['lang']) : null,
            title: $data['title'] ?? null,
            author: $data['author'] ?? null,
            marc: isset($data['marc']) ? Marc::fromArray($data['marc']) : null,
            materialType: isset($data['materialType']) ? MaterialType::fromArray($data['materialType']) : null,
            bibLevel: isset($data['bibLevel']) ? BibLevel::fromArray($data['bibLevel']) : null,
            publishYear: $data['publishYear'] ?? null,
            catalogDate: $data['catalogDate'] ?? null,
            country: isset($data['country']) ? Country::fromArray($data['country']) : null,
            orders: isset($data['orders']) ? array_map(
                OrderInfo::fromArray(...),
                $data['orders']
            ) : null,
            normTitle: $data['normTitle'] ?? null,
            normAuthor: $data['normAuthor'] ?? null,
            locations: isset($data['locations']) ? array_map(
                Location::fromArray(...),
                $data['locations']
            ) : null,
            holdCount: $data['holdCount'] ?? null,
            copies: $data['copies'] ?? null,
            callNumber: $data['callNumber'] ?? null,
            volumes: $data['volumes'] ?? null,
            items: $data['items'] ?? null,
            fixedFields: isset($data['fixedFields']) ? array_map(
                FixedField::fromArray(...),
                $data['fixedFields']
            ) : null,
            varFields: isset($data['varFields']) ? array_map(
                VarField::fromArray(...),
                $data['varFields']
            ) : null,
        );
    }

    /**
     * Convert the BibObject to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'updatedDate' => $this->updatedDate?->format('c'),
            'createdDate' => $this->createdDate?->format('c'),
            'deletedDate' => $this->deletedDate?->format('c'),
            'deleted' => $this->deleted,
            'suppressed' => $this->suppressed,
            'available' => $this->available,
            'isbn' => $this->isbn,
            'issn' => $this->issn,
            'upc' => $this->upc,
            'lang' => $this->lang?->toArray(),
            'title' => $this->title,
            'author' => $this->author,
            'marc' => $this->marc?->toArray(),
            'materialType' => $this->materialType?->toArray(),
            'bibLevel' => $this->bibLevel?->toArray(),
            'publishYear' => $this->publishYear,
            'catalogDate' => $this->catalogDate,
            'country' => $this->country?->toArray(),
            'orders' => $this->orders !== null && $this->orders !== [] ? array_map(
                fn (OrderInfo $order): array => $order->toArray(),
                $this->orders
            ) : null,
            'normTitle' => $this->normTitle,
            'normAuthor' => $this->normAuthor,
            'locations' => $this->locations !== null && $this->locations !== [] ? array_map(
                fn (Location $location): array => $location->toArray(),
                $this->locations
            ) : null,
            'holdCount' => $this->holdCount,
            'copies' => $this->copies,
            'callNumber' => $this->callNumber,
            'volumes' => $this->volumes,
            'items' => $this->items,
            'fixedFields' => $this->fixedFields !== null && $this->fixedFields !== [] ? array_map(
                fn (FixedField $fixedField): array => $fixedField->toArray(),
                $this->fixedFields
            ) : null,
            'varFields' => $this->varFields !== null && $this->varFields !== [] ? array_map(
                fn (VarField $varField): array => $varField->toArray(),
                $this->varFields
            ) : null,
        ];
    }

    /**
     * Get the full record URL for this bib record
     */
    public function getRecordUrl(?string $baseUrl = null): ?string
    {
        if ($baseUrl === null) {
            return null;
        }

        return rtrim($baseUrl, '/').'/bibs/'.$this->id;
    }

    /**
     * Check if this record is deleted
     */
    public function isDeleted(): bool
    {
        return $this->deleted === true || $this->deletedDate instanceof \DateTimeImmutable;
    }

    /**
     * Check if this record is suppressed
     */
    public function isSuppressed(): bool
    {
        return $this->suppressed === true;
    }

    /**
     * Get the primary title
     */
    public function getPrimaryTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Get the primary author
     */
    public function getPrimaryAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Get all ISBNs as a string
     */
    public function getIsbnString(): ?string
    {
        return $this->isbn;
    }

    /**
     * Get all ISSNs as a string
     */
    public function getIssnString(): ?string
    {
        return $this->issn;
    }

    /**
     * Get VarField by MARC tag
     */
    public function getVarFieldByTag(string $tag): ?VarField
    {
        if ($this->varFields === null) {
            return null;
        }

        foreach ($this->varFields as $varField) {
            if ($varField->marcTag === $tag || $varField->fieldTag === $tag) {
                return $varField;
            }
        }

        return null;
    }

    /**
     * Get all VarFields by MARC tag
     *
     * @return VarField[]
     */
    public function getVarFieldsByTag(string $tag): array
    {
        if ($this->varFields === null) {
            return [];
        }

        return array_filter(
            $this->varFields,
            fn (VarField $varField): bool => $varField->marcTag === $tag || $varField->fieldTag === $tag
        );
    }

    /**
     * Get FixedField by label
     */
    public function getFixedFieldByLabel(string $label): ?FixedField
    {
        if ($this->fixedFields === null) {
            return null;
        }

        foreach ($this->fixedFields as $fixedField) {
            if ($fixedField->label === $label) {
                return $fixedField;
            }
        }

        return null;
    }

    /**
     * Get all active orders
     *
     * @return OrderInfo[]
     */
    public function getActiveOrders(): array
    {
        if ($this->orders === null) {
            return [];
        }

        return array_filter(
            $this->orders,
            fn (OrderInfo $order): bool => $order->orderId !== '' // Since OrderInfo doesn't have status, we check for non-empty orderId
        );
    }

    /**
     * Get all URIs (not available in this version)
     *
     * @return Uri[]
     */
    public function getUris(): array
    {
        return [];
    }

    /**
     * Get primary location
     */
    public function getPrimaryLocation(): ?Location
    {
        if ($this->locations === null || $this->locations === []) {
            return null;
        }

        return $this->locations[0];
    }

    /**
     * Get material type display value
     */
    public function getMaterialTypeDisplay(): ?string
    {
        return $this->materialType?->getDisplayValue();
    }

    /**
     * Get bibliographic level display value
     */
    public function getBibLevelDisplay(): ?string
    {
        return $this->bibLevel?->getDisplayValue();
    }

    /**
     * Get language display name
     */
    public function getLanguageDisplay(): ?string
    {
        return $this->lang?->getDisplayName();
    }
}
