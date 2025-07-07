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
        public int $id,
        public ?DateTimeImmutable $updatedDate = null,
        public ?DateTimeImmutable $createdDate = null,
        public ?DateTimeImmutable $deletedDate = null,
        public ?bool $deleted = null,
        public ?bool $suppressed = null,
        public ?string $available = null,
        public ?Lang $lang = null,
        public ?string $title = null,
        public ?string $author = null,
        public ?MaterialType $materialType = null,
        public ?BibLevel $bibLevel = null,
        public ?string $publishYear = null,
        public ?string $catalogDate = null,
        public ?string $country = null,
        /** @var array<string>|null */
        public ?array $normTitle = null,
        /** @var array<string>|null */
        public ?array $normAuthor = null,
        /** @var Order[]|null */
        public ?array $orders = null,
        /** @var VarField[]|null */
        public ?array $varFields = null,
        /** @var FixedField[]|null */
        public ?array $fixedFields = null,
        /** @var Location[]|null */
        public ?array $locations = null,
        public ?int $holdCount = null,
        public ?int $copies = null,
        public ?string $recordType = null,
        public ?string $recordNumber = null,
        public ?string $campus = null,
        /** @var Uri[]|null */
        public ?array $uris = null,
        /** @var array<string>|null */
        public ?array $isbn = null,
        /** @var array<string>|null */
        public ?array $issn = null,
        /** @var array<string>|null */
        public ?array $oclc = null,
        /** @var array<string>|null */
        public ?array $lccn = null,
        /** @var array<string>|null */
        public ?array $subjects = null,
        /** @var array<string>|null */
        public ?array $genres = null,
        /** @var array<string>|null */
        public ?array $notes = null,
        /** @var array<string>|null */
        public ?array $seriesStatement = null,
        public ?string $edition = null,
        public ?string $imprint = null,
        public ?string $physicalDescription = null,
        /** @var array<string>|null */
        public ?array $contents = null,
        /** @var array<string>|null */
        public ?array $summary = null,
        public ?string $audience = null,
        public ?string $classification = null,
        /** @var array<string>|null */
        public ?array $alternativeTitles = null,
        /** @var array<string>|null */
        public ?array $relatedWorks = null,
        /** @var array<mixed>|null */
        public ?array $electronicResources = null,
        /** @var array<mixed>|null */
        public ?array $customFields = null,
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
            lang: isset($data['lang']) ? Lang::fromArray($data['lang']) : null,
            title: $data['title'] ?? null,
            author: $data['author'] ?? null,
            materialType: isset($data['materialType']) ? MaterialType::fromArray($data['materialType']) : null,
            bibLevel: isset($data['bibLevel']) ? BibLevel::fromArray($data['bibLevel']) : null,
            publishYear: $data['publishYear'] ?? null,
            catalogDate: $data['catalogDate'] ?? null,
            country: $data['country'] ?? null,
            normTitle: $data['normTitle'] ?? null,
            normAuthor: $data['normAuthor'] ?? null,
            orders: isset($data['orders']) ? array_map(
                fn (array $order): \VincentAuger\SierraSdk\Data\Order => Order::fromArray($order),
                $data['orders']
            ) : null,
            varFields: isset($data['varFields']) ? array_map(
                fn (array $varField): \VincentAuger\SierraSdk\Data\VarField => VarField::fromArray($varField),
                $data['varFields']
            ) : null,
            fixedFields: isset($data['fixedFields']) ? array_map(
                fn (array $fixedField): \VincentAuger\SierraSdk\Data\FixedField => FixedField::fromArray($fixedField),
                $data['fixedFields']
            ) : null,
            locations: isset($data['locations']) ? array_map(
                fn (array $location): \VincentAuger\SierraSdk\Data\Location => Location::fromArray($location),
                $data['locations']
            ) : null,
            holdCount: $data['holdCount'] ?? null,
            copies: $data['copies'] ?? null,
            recordType: $data['recordType'] ?? null,
            recordNumber: $data['recordNumber'] ?? null,
            campus: $data['campus'] ?? null,
            uris: isset($data['uris']) ? array_map(
                fn (array $uri): \VincentAuger\SierraSdk\Data\Uri => Uri::fromArray($uri),
                $data['uris']
            ) : null,
            isbn: $data['isbn'] ?? null,
            issn: $data['issn'] ?? null,
            oclc: $data['oclc'] ?? null,
            lccn: $data['lccn'] ?? null,
            subjects: $data['subjects'] ?? null,
            genres: $data['genres'] ?? null,
            notes: $data['notes'] ?? null,
            seriesStatement: $data['seriesStatement'] ?? null,
            edition: $data['edition'] ?? null,
            imprint: $data['imprint'] ?? null,
            physicalDescription: $data['physicalDescription'] ?? null,
            contents: $data['contents'] ?? null,
            summary: $data['summary'] ?? null,
            audience: $data['audience'] ?? null,
            classification: $data['classification'] ?? null,
            alternativeTitles: $data['alternativeTitles'] ?? null,
            relatedWorks: $data['relatedWorks'] ?? null,
            electronicResources: $data['electronicResources'] ?? null,
            customFields: $data['customFields'] ?? null,
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
            'lang' => $this->lang?->toArray(),
            'title' => $this->title,
            'author' => $this->author,
            'materialType' => $this->materialType?->toArray(),
            'bibLevel' => $this->bibLevel?->toArray(),
            'publishYear' => $this->publishYear,
            'catalogDate' => $this->catalogDate,
            'country' => $this->country,
            'normTitle' => $this->normTitle,
            'normAuthor' => $this->normAuthor,
            'orders' => $this->orders !== null && $this->orders !== [] ? array_map(
                fn (Order $order): array => $order->toArray(),
                $this->orders
            ) : null,
            'varFields' => $this->varFields !== null && $this->varFields !== [] ? array_map(
                fn (VarField $varField): array => $varField->toArray(),
                $this->varFields
            ) : null,
            'fixedFields' => $this->fixedFields !== null && $this->fixedFields !== [] ? array_map(
                fn (FixedField $fixedField): array => $fixedField->toArray(),
                $this->fixedFields
            ) : null,
            'locations' => $this->locations !== null && $this->locations !== [] ? array_map(
                fn (Location $location): array => $location->toArray(),
                $this->locations
            ) : null,
            'holdCount' => $this->holdCount,
            'copies' => $this->copies,
            'recordType' => $this->recordType,
            'recordNumber' => $this->recordNumber,
            'campus' => $this->campus,
            'uris' => $this->uris !== null && $this->uris !== [] ? array_map(
                fn (Uri $uri): array => $uri->toArray(),
                $this->uris
            ) : null,
            'isbn' => $this->isbn,
            'issn' => $this->issn,
            'oclc' => $this->oclc,
            'lccn' => $this->lccn,
            'subjects' => $this->subjects,
            'genres' => $this->genres,
            'notes' => $this->notes,
            'seriesStatement' => $this->seriesStatement,
            'edition' => $this->edition,
            'imprint' => $this->imprint,
            'physicalDescription' => $this->physicalDescription,
            'contents' => $this->contents,
            'summary' => $this->summary,
            'audience' => $this->audience,
            'classification' => $this->classification,
            'alternativeTitles' => $this->alternativeTitles,
            'relatedWorks' => $this->relatedWorks,
            'electronicResources' => $this->electronicResources,
            'customFields' => $this->customFields,
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
        if ($this->isbn === null || $this->isbn === []) {
            return null;
        }

        return implode(', ', $this->isbn);
    }

    /**
     * Get all ISSNs as a string
     */
    public function getIssnString(): ?string
    {
        if ($this->issn === null || $this->issn === []) {
            return null;
        }

        return implode(', ', $this->issn);
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
     * @return Order[]
     */
    public function getActiveOrders(): array
    {
        if ($this->orders === null) {
            return [];
        }

        return array_filter(
            $this->orders,
            fn (Order $order): bool => $order->status !== 'cancelled' && $order->status !== 'received'
        );
    }

    /**
     * Get all URIs
     *
     * @return Uri[]
     */
    public function getUris(): array
    {
        return $this->uris ?? [];
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
