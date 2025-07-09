<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\SierraSdk\Data\BibObject;
use VincentAuger\SierraSdk\Traits\QueryParam;

final class GetBib extends Request
{
    use CreatesDtoFromResponse;
    use QueryParam;

    protected Method $method = Method::GET;

    public function __construct(
        private int $id
    ) {}

    public function resolveEndpoint(): string
    {
        return '/bibs/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): BibObject
    {
        $data = $response->json();

        return BibObject::fromArray($data);

    }

    /**
     * Set the fields to include in the response.
     *
     * @param  array<string>  $fields
     */
    public function withFields(array $fields): self
    {
        $this->query()->add('fields', implode(',', $fields));

        return $this;
    }
}
