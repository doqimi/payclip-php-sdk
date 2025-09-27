# Payclip PHP SDK

[![Latest Stable Version](https://poser.pugx.org/doqimi/payclip-php-sdk/v)](https://packagist.org/packages/doqimi/payclip-php-sdk)
[![License](https://poser.pugx.org/doqimi/payclip-php-sdk/license)](LICENSE)

**Payclip PHP SDK** is a PHP library developed by [Doqimi](https://doqimi.com/) to simplify the integration with the [Clip API](https://developer.clip.mx/). This SDK provides an interface for PHP applications to interact with Clip's services.

## Current Status

This SDK is currently under initial development. At this stage, only the **Checkout API**, **Payments API** and **Settlements API** are implemented.

## Installation

You can install the SDK using Composer:

```bash
composer require doqimi/payclip-php-sdk
```

## Documentation

Please refer to the [official Clip API documentation](https://developer.clip.mx/) for full details on API endpoints, authentication, and integration.

The **Payclip PHP SDK** expects both the `CLIP_API_KEY` and `CLIP_API_SECRET` to be provided as parameters when initializing the `Client`.

If these are not explicitly provided, the SDK will attempt to read them from the environment variables:

- `CLIP_API_KEY`
- `CLIP_API_SECRET`

For information on how to generate these credentials for your account, please refer to the [Token de autenticación](https://developer.clip.mx/reference/token-de-autenticacion) section in the Clip developer documentation.

## Features

- [x] Checkout API (v2)
- [ ] Refunds
- [x] Payments
- [x] Settlements


## Contributing

Contributions are welcome. If you would like to contribute, please fork the repository and submit a pull request with your proposed changes.

## License

This project is open-sourced under the [MIT License](LICENSE).

---

Developed and maintained by [Doqimi](https://doqimi.com/)
