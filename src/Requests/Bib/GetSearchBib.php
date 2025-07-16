<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\SierraSdk\Data\BibSearchResultSet;
use VincentAuger\SierraSdk\Traits\HasFieldParams;

final class GetSearchBib extends Request
{
    use CreatesDtoFromResponse;
    use HasFieldParams;

    protected Method $method = Method::GET;

    public function __construct(
        public string $text,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $index = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/bibs/search';
    }

    public function createDtoFromResponse(Response $response): BibSearchResultSet
    {
        $data = $response->json();

        return BibSearchResultSet::fromArray($data);
    }

    public function defaultQuery(): array
    {
        $query = [
            'text' => $this->text,
        ];

        if ($this->limit !== null) {
            $query['limit'] = $this->limit;
        }

        if ($this->offset !== null) {
            $query['offset'] = $this->offset;
        }

        if ($this->index !== null) {
            $query['index'] = $this->index;
        }

        return $query;
    }
}
