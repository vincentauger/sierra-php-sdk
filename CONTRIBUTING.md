# CONTRIBUTING

Contributions are welcome, and are accepted via pull requests.
Please review these guidelines before submitting any pull requests.

## Process

1. Fork the project
1. Create a new branch
1. Code, test, commit and push
1. Open a pull request detailing your changes. Make sure to follow the [template](.github/PULL_REQUEST_TEMPLATE.md)

## Guidelines

* Please ensure the coding style running `composer lint`.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* Please remember that we follow [SemVer](http://semver.org/).

## Development Setup

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

## Running Tests

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

## Development Guidelines

- Follow PSR-12 coding standards (enforced by Laravel Pint)
- Add tests for new features using Pest
- Ensure PHPStan passes at level 9
- All public methods should have proper type hints and DocBlocks
