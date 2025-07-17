# Sierra API Query Factory

The Sierra PHP SDK provides a powerful factory pattern for building JSON queries for the Sierra API. This makes it easy to construct complex search queries in a type-safe and intuitive way.

## Basic Usage

### Simple Queries

```php
use VincentAuger\SierraSdk\Data\Query\QueryFactory;
use VincentAuger\SierraSdk\Requests\Bib\PostQueryBib;

// Search for bibliographic records with title "moby dick"
$query = QueryFactory::bib()
    ->field('t')  // title field
    ->equals('moby dick');

// Use the query in a request
$request = new PostQueryBib($query, limit: 10);
$response = $sierra->send($request);
```

### Supported Record Types

```php
// Bibliographic records
QueryFactory::bib()

// Item records
QueryFactory::item()

// Patron records
QueryFactory::patron()

// Order records
QueryFactory::order()

// Authority records
QueryFactory::authority()

// Holdings records
QueryFactory::holdings()

// Custom record type
QueryFactory::recordType('custom_type')
```

### Field Types

#### Variable-length Fields (Non-MARC)
```php
QueryFactory::bib()
    ->field('t')  // title field
    ->equals('science fiction');
```

#### MARC Fields
```php
QueryFactory::bib()
    ->marcField('245', '1', '0', 'a')  // MARC 245 field, indicators 1,0, subfield a
    ->equals('moby dick');
```

#### Fixed-length Fields and Record Properties
```php
QueryFactory::bib()
    ->fieldId(31)  // publication year (fixed-length field)
    ->range('2020', '2024');
```

#### Special Fields (MARC Leader/Control Fields)
```php
QueryFactory::bib()
    ->specialField(1001)  // MARC leader element
    ->equals('value');
```

### Expression Operators

#### Equals
```php
QueryFactory::bib()->field('t')->equals('exact title');
```

#### Has (contains)
```php
QueryFactory::bib()->field('a')->has('author name');
```

#### Range
```php
QueryFactory::bib()->fieldId(31)->range('2020', '2024');
```

#### Greater/Less Than
```php
QueryFactory::bib()->fieldId(31)->greater('2020');
QueryFactory::bib()->fieldId(31)->less('2024');
```

#### Between
```php
QueryFactory::bib()->fieldId(31)->between('2020', '2024');
```

#### Starts With
```php
QueryFactory::bib()->field('t')->startsWith('the');
```

#### Empty
```php
QueryFactory::bib()->field('n')->empty();
```

## Compound Queries

### AND Logic
```php
$titleQuery = QueryFactory::bib()->field('t')->equals('moby dick');
$authorQuery = QueryFactory::bib()->field('a')->has('melville');

$compoundQuery = QueryFactory::and($titleQuery, $authorQuery);
```

### OR Logic
```php
$title1 = QueryFactory::bib()->field('t')->equals('moby dick');
$title2 = QueryFactory::bib()->field('t')->equals('white whale');

$orQuery = QueryFactory::or($title1, $title2);
```

### Complex Nested Queries
```php
$fiction = QueryFactory::bib()->field('t')->has('fiction');
$recent = QueryFactory::bib()->fieldId(31)->range('2020', '2024');
$popular = QueryFactory::bib()->field('a')->has('popular');

// fiction AND (recent OR popular)
$complexQuery = QueryFactory::and(
    $fiction,
    QueryFactory::or($recent, $popular)
);
```

## Soft-linked Records

For soft-linked record types (like related resource records for orders):

```php
QueryFactory::bib()
    ->withRelation('related_resource', 'order')
    ->field('name')
    ->has('test');
```

## Real-world Examples

### Find Recent Science Fiction Books
```php
$query = QueryFactory::and(
    QueryFactory::bib()->field('t')->has('science fiction'),
    QueryFactory::bib()->fieldId(31)->greater('2020')
);

$request = new PostQueryBib($query, limit: 50);
```

### Find Items by Barcode
```php
$query = QueryFactory::item()
    ->field('b')  // barcode field
    ->equals('31234567890123');

$request = new PostQueryBib($query);
```

### Find Books by Multiple Authors
```php
$author1 = QueryFactory::bib()->field('a')->has('asimov');
$author2 = QueryFactory::bib()->field('a')->has('herbert');
$author3 = QueryFactory::bib()->field('a')->has('clarke');

$query = QueryFactory::or($author1, $author2, $author3);

$request = new PostQueryBib($query, limit: 100);
```

### MARC-specific Search
```php
// Search in MARC 245$a (main title)
$query = QueryFactory::bib()
    ->marcField('245', null, null, 'a')
    ->startsWith('the complete');

$request = new PostQueryBib($query);
```

## Generated JSON

The factory pattern generates JSON that matches the Sierra API specification. For example:

```php
QueryFactory::bib()->field('t')->equals('moby dick')
```

Generates:
```json
{
    "target": {
        "record": {
            "type": "bib"
        },
        "field": {
            "tag": "t"
        }
    },
    "expr": {
        "op": "equals",
        "operands": ["moby dick"]
    }
}
```

## Benefits

1. **Type Safety**: Compile-time checking of query structure
2. **Fluent Interface**: Intuitive method chaining
3. **Readable Code**: Self-documenting query construction
4. **Validation**: Proper JSON structure guaranteed
5. **IDE Support**: Full autocomplete and documentation
6. **Maintainable**: Easy to modify and extend queries

## Migration from Manual JSON

Before:
```php
$jsonQuery = [
    'target' => [
        'record' => ['type' => 'bib'],
        'field' => ['tag' => 't']
    ],
    'expr' => [
        'op' => 'equals',
        'operands' => ['moby dick']
    ]
];
```

After:
```php
$query = QueryFactory::bib()->field('t')->equals('moby dick');
```
