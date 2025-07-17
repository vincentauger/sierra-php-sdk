<?php

declare(strict_types=1);

/**
 * Examples demonstrating the Sierra API Query Factory Pattern
 *
 * This file shows how to use the QueryFactory to build various types of queries
 * for the Sierra API in an easy and intuitive way.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use VincentAuger\SierraSdk\Data\Query\QueryFactory;
use VincentAuger\SierraSdk\Requests\Bib\PostQueryBib;

// Example 1: Simple query for bibliographic title equals "moby dick"
$query1 = QueryFactory::bib()
    ->field('t')  // title field
    ->equals('moby dick');

echo "Example 1 - Simple title search:\n";
echo json_encode($query1->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 2: Search for author containing "melville"
$query2 = QueryFactory::bib()
    ->field('a')  // author field
    ->has('melville');

echo "Example 2 - Author search:\n";
echo json_encode($query2->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 3: MARC field search - search in MARC field 245 (title)
$query3 = QueryFactory::bib()
    ->marcField('245', null, null, 'a')
    ->equals('moby dick');

echo "Example 3 - MARC field search:\n";
echo json_encode($query3->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 4: Compound query with AND - title AND author
$titleQuery = QueryFactory::bib()->field('t')->equals('moby dick');
$authorQuery = QueryFactory::bib()->field('a')->has('melville');
$compoundQuery = QueryFactory::and($titleQuery, $authorQuery);

echo "Example 4 - Compound query (title AND author):\n";
echo json_encode($compoundQuery->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 5: Compound query with OR - multiple titles
$title1 = QueryFactory::bib()->field('t')->equals('moby dick');
$title2 = QueryFactory::bib()->field('t')->equals('white whale');
$orQuery = QueryFactory::or($title1, $title2);

echo "Example 5 - Compound query (title1 OR title2):\n";
echo json_encode($orQuery->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 6: Using the query in a PostQueryBib request
$searchQuery = QueryFactory::bib()
    ->field('t')
    ->has('science');

$request = new PostQueryBib($searchQuery, limit: 10, offset: 0);

echo "Example 6 - Using query in PostQueryBib request:\n";
echo "Query body: " . json_encode($request->defaultBody(), JSON_PRETTY_PRINT) . "\n";
echo "Query params: " . json_encode($request->defaultQuery(), JSON_PRETTY_PRINT) . "\n\n";

// Example 7: Range search (publication year)
$rangeQuery = QueryFactory::bib()
    ->fieldId(31)  // publication year field ID
    ->range('2020', '2024');

echo "Example 7 - Range search (publication year 2020-2024):\n";
echo json_encode($rangeQuery->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 8: Item search
$itemQuery = QueryFactory::item()
    ->field('b')  // barcode field
    ->equals('123456789');

echo "Example 8 - Item barcode search:\n";
echo json_encode($itemQuery->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Example 9: Complex nested query
$fiction = QueryFactory::bib()->field('t')->has('fiction');
$recent = QueryFactory::bib()->fieldId(31)->range('2020', '2024');
$popular = QueryFactory::bib()->field('a')->has('popular');

$complexQuery = QueryFactory::and(
    $fiction,
    QueryFactory::or($recent, $popular)
);

echo "Example 9 - Complex nested query (fiction AND (recent OR popular)):\n";
echo json_encode($complexQuery->toArray(), JSON_PRETTY_PRINT) . "\n\n";
