# Sierra SDK for PHP (Unofficial)

A modern PHP SDK for the Sierra ILS API (v6) platform, built for maintainability and clarity using [Saloon](https://docs.saloon.dev) for HTTP integration.

> **Current Status:** Focused on querying (read-only) the **Bibliographic API (Bib API)**. Designed for future expansion to other Sierra endpoints.

For detailed information on the Sierra API, visit the [docs](https://techdocs.iii.com/sierraapi/Content/titlePage.htm)

---

## Features

- ✅ PHP 8.4+ with modern syntax (typed properties, readonly, enums, attributes)
- ✅ Clean HTTP layer built on [Saloon](https://docs.saloon.dev)
- ✅ PSR-4 autoloading and testable structure
- ✅ Composer-native and framework-agnostic

---

## Installation

```bash
composer require vincentauger/sierra-sdk
```

## Usage

### Initialize the client

```php
use VincentAuger\SierraSdk\Sierra;

$sierra = new Sierra(
    baseUrl: 'https://your.sierra.server/iii/sierra-api/v6',
    clientKey: 'your_client_key',
    clientSecret: 'your_client_secret',
);
```

### Fetch a bibliographic record

```php
use VincentAuger\SierraSdk\Requests\Bib\GetBib;

$request = new GetBib(123456);
$response = $sierra->send($request);
$record = $request->createDtoFromResponse($response);

echo $record->title;        // Access via typed DTO
echo $record->author;
echo $record->materialType?->getDisplayValue();
```

### Search the bibliographic index

```php
use VincentAuger\SierraSdk\Requests\Bib\GetSearchBib;

$request = new GetSearchBib('climate change');
$response = $sierra->send($request);
$results = $request->createDtoFromResponse($response);

foreach ($results->entries as $entry) {
    echo $entry->bib->id . ': ' . $entry->bib->title . PHP_EOL;
}
```

### Advanced querying with QueryFactory

For detailed query examples and advanced usage, see the [Query Factory documentation](docs/QUERY_FACTORY.md).

```php
use VincentAuger\SierraSdk\Data\Query\QueryFactory;
use VincentAuger\SierraSdk\Requests\Bib\PostQueryBib;

// Search for titles starting with "climate"
$query = QueryFactory::bib()
    ->field('t')  // title field
    ->startsWith('climate');

$request = new PostQueryBib($query, limit: 25);
$response = $sierra->send($request);
$results = $request->createDtoFromResponse($response);

foreach ($results->entries as $bibId) {
    // Get full record details
    $bibRequest = new GetBib($bibId);
    $bibResponse = $sierra->send($bibRequest);
    $bib = $bibRequest->createDtoFromResponse($bibResponse);

    echo $bib->title . PHP_EOL;
}
```

## Configuration

You must provide:

| Parameter | Description |
|-----------|-------------|
| baseUrl | Base URL of the Sierra API (ends with `/v6`) |
| clientKey | OAuth2 client key |
| clientSecret | OAuth2 client secret |

## Structure

- **Sierra** – main entry point, wraps Saloon connector
- **Requests** – one Saloon Request per endpoint (e.g., GetBib, GetSearchBib, PostQueryBib)
- **Data** – Data DTOs for API responses (e.g., BibObject, BibResultSet, BibSearchResultSet)
- **Tests** – Pest tests

## Roadmap

- [x] Basic client and authentication
- [x] Query the bib records `GET /v6/bibs/`
- [x] Search the bib records `GET /v6/bibs/search`
- [x] Query the bib records with JSON `POST /v6/bibs/search`
- [x] Fetch single bib record `GET /v6/bibs/{id}`

## Requirements

- PHP 8.4+
- Composer
- Saloon (installed automatically)

## Contributing

Contributions are welcome! Please open a pull request with tests and documentation.

### Development Setup

1. **Clone the repository**

   ```bash
   git clone https://github.com/vincentauger/sierra-php-sdk.git
   cd sierra-php-sdk
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Set up environment (optional, for testing against real API)**

By default, the test will use the existing fixtures.

   ```bash
   cp .env.example .env
   # Edit .env with your Sierra API credentials
   ```

### Running Tests

The project uses several tools to ensure code quality:

```bash
# Run all tests and checks
composer test

# Individual tools
composer test:unit      # Pest unit tests
composer test:lint      # Laravel Pint code style check
composer test:types     # PHPStan static analysis
composer test:refactor  # Rector refactoring checks

# Fix code style issues
composer lint           # Apply Laravel Pint fixes
composer refactor       # Apply Rector refactoring
```

### Development Guidelines

- Follow PSR-12 coding standards (enforced by Laravel Pint)
- Add tests for new features using Pest
- Ensure PHPStan passes at level 9
- All public methods should have proper type hints and DocBlocks

Feel free to open issues for questions or feedback.

## License

MIT License — see the LICENSE file for details.

## Disclaimer

- This SDK is not affiliated with [Innovative Interfaces Inc.](https://www.iii.com/)
- Use at your own risk. Respect your ILS API usage limits and security requirements.
