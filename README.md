# Laravel Easy Theme

## Install
```bash
composer require eslym/laravel-easy-theme
```
### Without package discovery
#### Provider
```php
[
    "Eslym\\EasyTheme\\Providers\\ThemeServiceProvider"
]
```
#### Alias
```php
[
    "Theme" => "Eslym\\EasyTheme\\Facades\\Theme"
]
```
## Publish
```bash
php artisan vendor:publish --provider="Eslym\EasyTheme\Providers\ThemeServiceProvider" --tag="config"
```