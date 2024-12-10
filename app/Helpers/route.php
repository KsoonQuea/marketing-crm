<?php

if (! function_exists('routeActive')) {
    function routeActive($routeName, $type = 1)
    {
        if ($type === 2) {
            return collect($routeName)->map(fn ($route) => request()->routeIs($route))->contains(true) ? 'block' : 'none';
        }

        return	request()->routeIs($routeName) ? 'active' : '';
    }
}
if (! function_exists('backToHome')) {
    function backToHome()
    {
        return (request()->is('admin/*') || request()->is('admin')) ? route('admin.index') : route('user.index');
    }
}
