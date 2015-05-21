#Boca

A library for interfacing with Boca printers.

## Requirements

- PHP >=5.3

## Installation

Install the package using Composer. Edit your project's `composer.json` file to require `phillipsdata/boca`.

```js
  "require": {
    "phillipsdata/boca": "~1.0"
  }
```

## Basic Usage

```php
use PhillipsData\Boca\Connection;
use PhillipsData\Boca\Transport;

$connection = new Connection('tcp://127.0.0.1:9100');
$connection->open();

$transport = new Transport($connection);
$response = $transport->send('<MAC>\n\n');

$connection->close();
echo $response; // outputs something like: MAC Address: 00:0D:00:00:01
```
