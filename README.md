Rakit Blade
----------------

Blade Template Engine outside Laravel Framework.

## Usage Example 

```php
<?php

require('vendor/autoload.php');

use Rakit\Blade\Blade;

$view_paths = [ __DIR__.' /views' ];
$view_cache_path = __DIR__.'/cache/views';

$blade = new Blade($view_paths, $view_cache_path);

// then, you can render blade file using `render` method
$rendered = $blade->render('myview');

// or render with data
$rendered = $blade->render('myview', [ 'message' => 'foobar' ]);

```

## Extending Compiler

You can extend compiler using `extend` method. 

```php

// register @upper() compiler 
$blade->extend(function($view, $compiler) {
    $pattern = $compiler->createMatcher('upper');
    return preg_replace($pattern, '$1<?php echo strtoupper($2); ?>', $view);
});

// you can use it in your view file by @upper('my string')

```

