<?php

namespace Frysch\LaravelLocalizationTwig;

use LaravelLocalization;

class UrlHelper{
    
    /**
     * Get localized url from route name
     *
     * @param string  $route 
     * @param array   $attributes 
     * @param string  $locale    Fetches current locale if not supplied
     * @param string  $forceDefaultLocation 
     * @return string|bool
     */
    public static function getByRoute($route, $attributes = [], $locale = null, $forceDefaultLocation = false)
    {
        $route = 'routes.'.$route;
        $locale = $locale? : LaravelLocalization::getCurrentLocale();
        return LaravelLocalization::getURLFromRouteNameTranslated(
            $locale,
            $route,
            $attributes,
            $forceDefaultLocation
        );
    }
    
    
    /**
     * Test route is current
     *
     * @param string  $testRoute 
     * @return bool
     */
    public static function isCurrentRoute($testRoute) {
        $routeName = LaravelLocalization::getRouteNameFromAPath(urldecode(url()->current()));
        return $routeName ? ($testRoute === str_replace('routes.', '', $routeName)) : false;
    }
}