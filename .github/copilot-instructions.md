# Sierra PHP SDK Instructions

## Core Rules
- Use PHP 8.4+ syntax only
- Add `declare(strict_types=1);` to every PHP file
- Make all classes final unless inheritance is required
- Use readonly properties wherever possible
- Use constructor property promotion
- Use typed properties and return types

## Namespaces
- Base: `VincentAuger\SierraSdk`
- Data: `VincentAuger\SierraSdk\Data`
- Requests: `VincentAuger\SierraSdk\Requests`
- Enums: `VincentAuger\SierraSdk\Enums`

## Class Requirements
- DTOs are `final readonly`
- Requests extend `Saloon\Http\Request`
- Requests are `final`
- Enums are backed enums with string or int values
