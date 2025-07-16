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
use VincentAuger\SierraSdk\Client;

$client = new Client(
    baseUrl: 'https://your.sierra.server/iii/sierra-api/v6',
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
| baseUrl | Base URL of the Sierra API (ends with `/v6`) |
| clientKey | OAuth2 client key |
| clientSecret | OAuth2 client secret |

## Structure

- **Client** – main entry point, wraps Saloon connector
- **Requests** – one Saloon Request per endpoint (e.g., GetBibRecordRequest)
- **Data** – Data DTOs for API responses
- **Exceptions** – custom exceptions for API and response errors
- **Tests** – PHPUnit test coverage (coming soon)

## Roadmap

- [x] Basic client and authentication
- [x] Query the bib records `GET /v6/bibs/`
- [ ] Search the bib records `GET /v6/bibs/search`
- [ ] Fetch single bib record `GET /v6/bibs/{id}`
- [ ] Metadata search `GET /v6/bibs/metadata`

## Requirements

- PHP 8.4+
- Composer
- Saloon (installed automatically)

## Contributing

Contributions are welcome! Please open a pull request with tests and documentation.
Feel free to open issues for questions or feedback.

## License

MIT License — see the LICENSE file for details.

## Disclaimer

- This SDK is not affiliated with Innovative Interfaces Inc.
- Use at your own risk. Respect your ILS API usage limits and security requirements.
