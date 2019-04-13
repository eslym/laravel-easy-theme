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

# How to use
## Structure
```
public/
└── themes/
     ├── default
     │   └── index.blade.php
     └── theme_b
          └── index.blade.php
```
## Code
```php
Route::get('/', function(){
    return Theme::view('index')
        ->response();
});
```