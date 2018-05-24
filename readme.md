# iTexMo PHP Wrapper for Laravel

## Installation
```
composer require laravelcebu/itexmo-php
```

## Usage
```php
use LaravelCebu\Itexmo;

$sms = new Itexmo();

$sms->send('xxxxxxxxxxx', 'Hello World!');
```
