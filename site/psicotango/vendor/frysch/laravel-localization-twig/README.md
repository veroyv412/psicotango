# Laravel Localization Twig
Adding twig functions for [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

## Dependecies:
- [rcrowe/TwigBridge](https://github.com/rcrowe/TwigBridge)
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

## Instructions

Install with composer
```
composer require frysch/laravel-localization-twig
```

Add twig extension in app/config/twigbridge.php
```
'extensions' => [
    'enabled' => [
        /*** Other enabled extensions ***/
        'Frysch\LaravelLocalizationTwig\LocalizeUrlExtension'
    ]
]
```

## Twig functions

3 functions just maps to LaravelLocalization methods:

```localized_url ```              -> ``` LaravelLocalization::getLocalizedURL```

```localized_locales_ordered```   -> ``` LaravelLocalization::getLocalesOrder```

```localized_locales_supported``` -> ``` LaravelLocalization::getSupportedLocales```

```localized_route``` sort of maps to ``` LaravelLocalization::getURLFromRouteNameTranslated``` , but arguments is not in the same order and it defaults to current locale if not supplied. Make sure you put your localized routes in lang/routes.php as per mcamara/laravel-localization instructions.

```php
public static function getByRoute($route, $attributes = [], $locale = null, $forceDefaultLocation = false)
```
