<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=5.0"
    />
    <link rel="icon" href="/favicon.svg" />
    @routes
    @viteReactRefresh
    @vite([
        'resources/css/app.css',
        'resources/js/app.tsx'
    ])
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>