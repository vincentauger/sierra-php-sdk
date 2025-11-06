# Security

## Reporting Issues

If you find a security issue in this SDK, please open a GitHub issue. Since this is a client SDK for the public Sierra ILS API, most security concerns will be addressed promptly through normal bug fixes.

## Credential Safety

This SDK requires Sierra API credentials for authentication:

- **Never commit credentials to version control**
- Store credentials in `.env` files (already gitignored)
- Use environment variables for production deployments
- Rotate credentials if accidentally exposed

## Notes

- This SDK only communicates with Sierra ILS API endpoints over HTTPS
- All input validation follows Sierra's API requirements
- Security updates are released as needed and documented in [CHANGELOG.md](CHANGELOG.md)
