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
        public ?array $normTitle = null,
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
        public ?array $isbn = null,
        public ?array $issn = null,
        public ?array $oclc = null,
        public ?array $lccn = null,
        public ?array $subjects = null,
        public ?array $genres = null,
        public ?array $notes = null,
        public ?array $seriesStatement = null,
        public ?string $edition = null,
        public ?string $imprint = null,
        public ?string $physicalDescription = null,
        public ?array $contents = null,
        public ?array $summary = null,
        public ?string $audience = null,
        public ?string $classification = null,
        public ?array $alternativeTitles = null,
        public ?array $relatedWorks = null,
        public ?array $electronicResources = null,
        public ?array $customFields = null,
    ) {}

    /**
     * Create a BibObject from Sierra API response data
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
                fn (array $order) => Order::fromArray($order),
                $data['orders']
            ) : null,
            varFields: isset($data['varFields']) ? array_map(
                fn (array $varField) => VarField::fromArray($varField),
                $data['varFields']
            ) : null,
            fixedFields: isset($data['fixedFields']) ? array_map(
                fn (array $fixedField) => FixedField::fromArray($fixedField),
                $data['fixedFields']
            ) : null,
            locations: isset($data['locations']) ? array_map(
                fn (array $location) => Location::fromArray($location),
                $data['locations']
            ) : null,
            holdCount: $data['holdCount'] ?? null,
            copies: $data['copies'] ?? null,
            recordType: $data['recordType'] ?? null,
            recordNumber: $data['recordNumber'] ?? null,
            campus: $data['campus'] ?? null,
            uris: isset($data['uris']) ? array_map(
                fn (array $uri) => Uri::fromArray($uri),
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
            'orders' => $this->orders ? array_map(
                fn (Order $order) => $order->toArray(),
                $this->orders
            ) : null,
            'varFields' => $this->varFields ? array_map(
                fn (VarField $varField) => $varField->toArray(),
                $this->varFields
            ) : null,
            'fixedFields' => $this->fixedFields ? array_map(
                fn (FixedField $fixedField) => $fixedField->toArray(),
                $this->fixedFields
            ) : null,
            'locations' => $this->locations ? array_map(
                fn (Location $location) => $location->toArray(),
                $this->locations
            ) : null,
            'holdCount' => $this->holdCount,
            'copies' => $this->copies,
            'recordType' => $this->recordType,
            'recordNumber' => $this->recordNumber,
            'campus' => $this->campus,
            'uris' => $this->uris ? array_map(
                fn (Uri $uri) => $uri->toArray(),
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
        return $this->deleted === true || $this->deletedDate !== null;
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
        if ($this->isbn === null || empty($this->isbn)) {
            return null;
        }

        return implode(', ', $this->isbn);
    }

    /**
     * Get all ISSNs as a string
     */
    public function getIssnString(): ?string
    {
        if ($this->issn === null || empty($this->issn)) {
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
     */
    public function getVarFieldsByTag(string $tag): array
    {
        if ($this->varFields === null) {
            return [];
        }

        return array_filter(
            $this->varFields,
            fn (VarField $varField) => $varField->marcTag === $tag || $varField->fieldTag === $tag
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
     */
    public function getActiveOrders(): array
    {
        if ($this->orders === null) {
            return [];
        }

        return array_filter(
            $this->orders,
            fn (Order $order) => $order->status !== 'cancelled' && $order->status !== 'received'
        );
    }

    /**
     * Get all URIs
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
        if ($this->locations === null || empty($this->locations)) {
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
