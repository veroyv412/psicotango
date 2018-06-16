<?php

namespace Frysch\LaravelLocalizationTwig;

use LaravelLocalization;
use Twig_Extension;
use Twig_SimpleFunction;

class LocalizeUrlExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'LaravelLocalization';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('l10n_url_by_route', ['Frysch\\LaravelLocalizationTwig\\UrlHelper', 'getByRoute'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('l10n_url', ['LaravelLocalization', 'getLocalizedURL'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('l10n_locales_ordered', ['LaravelLocalization', 'getLocalesOrder']),
            new Twig_SimpleFunction('l10n_locales_supported', ['LaravelLocalization', 'getSupportedLocales']),
            new Twig_SimpleFunction('l10n_is_current_route', ['Frysch\\LaravelLocalizationTwig\\UrlHelper', 'isCurrentRoute']),
        ];
    }
}