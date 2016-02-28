
# Tale Loader
**A Tale Framework Component**

# What is Tale Loader?

A PSR-4 and PSR-0 compatible loader without other dependencies

# Installation

Install via Composer

```bash
composer require "talesoft/tale-loader:*"
composer install
```

# Usage

Assuming the following structure:
```
/library
    /App.php
    /App
        /Middleware.php
    /Db.php
    /Db/Table.php
```

do

```php
use Tale\Loader;


$loader = new Loader(__DIR__.'/library');
$loader->register();
```

and you're done.

To disable the loader you can unregister it (which it will do automatically upon destruction)

```php
$loader->unregister();
```

If you want to map a namespace on your directory, use the second argument

```php
$loader = new Loader(__DIR__.'/vendor/my/app', 'My\\App\\');
```


If your files are named differently, use the third parameter

```php
$loader = new Loader(__DIR__.'/lib', 'My\\', '%s.class.php');
```

That's all it can do any probably ever will.
Maybe optional class maps will be implemented.