<?php

declare(strict_types=1);

use VincentAuger\SierraSdk\Data\Query\QueryFactory;
use VincentAuger\SierraSdk\Requests\Bib\PostQueryBib;

it('can create a simple bibliographic title query', function (): void {
    $query = QueryFactory::bib()
        ->field('t')
        ->equals('moby dick');

    $expected = [
        'target' => [
            'record' => ['type' => 'bib'],
            'field' => ['tag' => 't']
        ],
        'expr' => [
            'op' => 'equals',
            'operands' => ['moby dick']
        ]
    ];

    expect($query->toArray())->toBe($expected);
});

it('can create a MARC field query', function (): void {
    $query = QueryFactory::bib()
        ->marcField('245', '1', '0', 'a')
        ->equals('moby dick');

    $expected = [
        'target' => [
            'record' => ['type' => 'bib'],
            'field' => [
                'marcTag' => '245',
                'ind1' => '1',
                'ind2' => '0',
                'subfields' => 'a'
            ]
        ],
        'expr' => [
            'op' => 'equals',
            'operands' => ['moby dick']
        ]
    ];

    expect($query->toArray())->toBe($expected);
});

it('can create a field ID query', function (): void {
    $query = QueryFactory::bib()
        ->fieldId(31)
        ->range('2020', '2024');

    $expected = [
        'target' => [
            'record' => ['type' => 'bib'],
            'id' => 31
        ],
        'expr' => [
            'op' => 'range',
            'operands' => ['2020', '2024']
        ]
    ];

    expect($query->toArray())->toBe($expected);
});

it('can create compound queries with AND', function (): void {
    $titleQuery = QueryFactory::bib()->field('t')->equals('moby dick');
    $authorQuery = QueryFactory::bib()->field('a')->has('melville');
    $compoundQuery = QueryFactory::and($titleQuery, $authorQuery);

    $expected = [
        'queries' => [
            [
                'target' => [
                    'record' => ['type' => 'bib'],
                    'field' => ['tag' => 't']
                ],
                'expr' => [
                    'op' => 'equals',
                    'operands' => ['moby dick']
                ]
            ],
            'AND',
            [
                'target' => [
                    'record' => ['type' => 'bib'],
                    'field' => ['tag' => 'a']
                ],
                'expr' => [
                    'op' => 'has',
                    'operands' => ['melville']
                ]
            ]
        ]
    ];

    expect($compoundQuery->toArray())->toBe($expected);
});

it('can create compound queries with OR', function (): void {
    $title1 = QueryFactory::bib()->field('t')->equals('moby dick');
    $title2 = QueryFactory::bib()->field('t')->equals('white whale');
    $orQuery = QueryFactory::or($title1, $title2);

    $expected = [
        'queries' => [
            [
                'target' => [
                    'record' => ['type' => 'bib'],
                    'field' => ['tag' => 't']
                ],
                'expr' => [
                    'op' => 'equals',
                    'operands' => ['moby dick']
                ]
            ],
            'OR',
            [
                'target' => [
                    'record' => ['type' => 'bib'],
                    'field' => ['tag' => 't']
                ],
                'expr' => [
                    'op' => 'equals',
                    'operands' => ['white whale']
                ]
            ]
        ]
    ];

    expect($orQuery->toArray())->toBe($expected);
});

it('can create queries for different record types', function (): void {
    $bibQuery = QueryFactory::bib()->field('t')->equals('test');
    $itemQuery = QueryFactory::item()->field('b')->equals('12345');
    $patronQuery = QueryFactory::patron()->fieldId(1)->equals('john');

    expect($bibQuery->toArray()['target']['record']['type'])->toBe('bib');
    expect($itemQuery->toArray()['target']['record']['type'])->toBe('item');
    expect($patronQuery->toArray()['target']['record']['type'])->toBe('patron');
});

it('can use different expression operators', function (): void {
    $hasQuery = QueryFactory::bib()->field('t')->has('science');
    $startsWithQuery = QueryFactory::bib()->field('t')->startsWith('the');
    $greaterQuery = QueryFactory::bib()->fieldId(31)->greater('2020');
    $emptyQuery = QueryFactory::bib()->field('n')->empty();

    expect($hasQuery->toArray()['expr']['op'])->toBe('has');
    expect($startsWithQuery->toArray()['expr']['op'])->toBe('starts_with');
    expect($greaterQuery->toArray()['expr']['op'])->toBe('greater');
    expect($emptyQuery->toArray()['expr']['op'])->toBe('empty');
});

it('can be used in PostQueryBib request', function (): void {
    $query = QueryFactory::bib()
        ->field('t')
        ->has('science');

    $request = new PostQueryBib($query, limit: 10, offset: 5);

    expect($request->defaultBody())->toBe($query->toArray());
    expect($request->defaultQuery())->toBe(['limit' => 10, 'offset' => 5]);
});

it('can create queries with relations for soft-linked records', function (): void {
    $query = QueryFactory::bib()
        ->withRelation('related_resource', 'order')
        ->field('name')
        ->has('test');

    $expected = [
        'target' => [
            'record' => [
                'type' => 'bib',
                'relationType' => 'related_resource',
                'relationTag' => 'order'
            ],
            'field' => ['tag' => 'name']
        ],
        'expr' => [
            'op' => 'has',
            'operands' => ['test']
        ]
    ];

    expect($query->toArray())->toBe($expected);
});

it('can create queries with special fields', function (): void {
    $query = QueryFactory::bib()
        ->specialField(1001)
        ->equals('value');

    $expected = [
        'target' => [
            'record' => ['type' => 'bib'],
            'specialField' => 1001
        ],
        'expr' => [
            'op' => 'equals',
            'operands' => ['value']
        ]
    ];

    expect($query->toArray())->toBe($expected);
});
