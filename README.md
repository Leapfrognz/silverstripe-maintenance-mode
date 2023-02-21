# Silverstripe Maintenance Mode
Adds the ability to put a Silverstripe website in maintenance mode. While in maintenance mode a generic maintenance
page will be displayed for all regular visitors. Site administrators can still access the CMS and navigate the website
as usual.

## Requirements
* See `composer.json` requirements

## Installation
* `composer require wedevelopnl/silverstripe-maintenance-mode`
* Run a `dev/build`

## License
See [License](LICENSE)

## Maintainers
* [WeDevelop](https://www.wedevelop.nl/) <development@wedevelop.nl>

## Development and contribution
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
See read our [contributing](CONTRIBUTING.md) document for more information.

### Getting started
We advise to use [Docker](https://docker.com)/[Docker compose](https://docs.docker.com/compose/) for development.\
We also included a [Makefile](https://www.gnu.org/software/make/) to simplify some commands

Our development container contains some built-in tools like `PHPCSFixer`.
