# LYRASOFT Sequence Package

To get unique serial numbers for any record.

## Installation

Install from composer

```shell
composer require lyrasoft/sequence
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/sequence -t migrations
```

You must manually add `SequencePackage::class` to `etc/di.php`

```php
// ...

    'providers' => [
        \Lyrasoft\Sequence\SequencePackage::class
    ],

// ...
```

# Usage

```php
$sequenceServcie = $app->service(\Lyrasoft\Sequence\Service\SequenceService::class);

$serial = $sequenceServcie->getNextSerial('order', 'FN-'); // 15
$serial = $sequenceServcie->getNextSerialAndPadZero('order', 'FN-', 7); // 0000015
$serial = $sequenceServcie->getNextSerialWithPrefix('order', 'FN-', 7); // FN-0000015
```
