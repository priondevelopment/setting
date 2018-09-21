# Prion Setting (Lumen/Laraval 5 Package)

Prion Setting is an easy way to pull and save updates.

Tested on Lumen 5.6

## Installation

`composer require "priondevelopment/setting:5.6.*"`

In config/app.php, add the following provider:
PrionDevelopment\Providers\PrionSettingProvider::class

Publish configuration files
`php artisan vendor:publish --tag="prionsetting"`

### Automated Setup
`php artisan setting:setup`

### Manual Setup

Publish the Migrations
`php artisan setting:migration`
`php artisan migrate`

Publish the Models
`php artisan setting:setting`
`php artisan setting:setting_log`
`php artisan setting:setting_observer`


Clear or reset your Laravel config cache.
php artisan config:clear
php artisan config:cache


## License

Prion Setting is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
