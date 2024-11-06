# Simple PHP Router
A simple PHP router for your projects.

## Installation
You can use this router in your project by installing it via Composer
```bash
composer require diogof648/simple-php-router
```

## Usage
```php
<?php

use Diogof648\SimplePhpRouter\Router;

Router::get('/home', function () {
    echo "Home";
});

Router::post(...);
Router::patch(...);
Router::put(...);
Router::delete(...);
Router::any(...);

// If no match
Router::noMatch();
// OR
Router::noMatch(function () {
    echo "Not Found";
});
```

## Contributing
If you have any issues or ideas, feel free to open an issue—I’ll respond as quickly as possible!

Pull requests are warmly welcomed. Make sure to update the tests !!

## License
[MIT](https://github.com/diogof648-dev/simple-php-router/blob/develop/LICENSE)