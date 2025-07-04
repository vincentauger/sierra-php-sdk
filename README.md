# Sierra SDK for PHP

A modern PHP SDK for the Sierra ILS API platform, built for maintainability and clarity using [Saloon](https://docs.saloon.dev) for HTTP integration and [Laravel Data](https://spatie.be/docs/laravel-data) for data transfer objects (DTOs).

> **Current Status:** Focused on the **Bibliographic API (Bib API)**. Designed for future expansion to other Sierra endpoints.

---

## Features

- ✅ PHP 8.4+ with modern syntax (typed properties, readonly, enums, attributes)
- ✅ Clean HTTP layer built on [Saloon](https://docs.saloon.dev)
- ✅ Typed, immutable DTOs using [Laravel Data](https://spatie.be/docs/laravel-data)
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
use VincentAuger\SierraSdk\Client;

$client = new Client(
    baseUrl: 'https://your.sierra.server/iii/sierra-api/v6/',
    clientKey: 'your_client_key',
    clientSecret: 'your_client_secret',
);
```

### Fetch a bibliographic record

```php
$record = $client->getBibRecord(123456);

echo $record->title;     // Access via typed DTO
echo $record->recordType;
```

### Search the bibliographic index

```php
$results = $client->searchBibIndex('title="climate change"');

foreach ($results->records as $bib) {
    echo $bib->id . ': ' . $bib->title . PHP_EOL;
}
```

## Configuration

You must provide:

| Parameter | Description |
|-----------|-------------|
| baseUrl | Base URL of the Sierra API |
| clientKey | OAuth2 client key |
| clientSecret | OAuth2 client secret |

## Structure

- **Client** – main entry point, wraps Saloon connector
- **Requests** – one Saloon Request per endpoint (e.g., GetBibRecordRequest)
- **Data** – Laravel Data DTOs for API responses
- **Exceptions** – custom exceptions for API and response errors
- **Tests** – PHPUnit test coverage (coming soon)

## Roadmap

- [x] Basic client and authentication
- [x] Fetch single bib record
- [x] Search bib index
- [ ] Handle pagination
- [ ] Add support for Items, Patrons, etc.
- [ ] Improve error handling and response caching

## Requirements

- PHP 8.4+
- Composer
- Laravel Data (installed automatically)
- Saloon (installed automatically)

## Contributing

Contributions are welcome! Please open a pull request with tests and documentation.
Feel free to open issues for questions or feedback.

## License

MIT License — see the LICENSE file for details.

## Disclaimer

- This SDK is not affiliated with Innovative Interfaces Inc.
- Use at your own risk. Respect your ILS API usage limits and security requirements.
