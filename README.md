# CakePHP Encrypted Type

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This plugin provides a CakePHP 3 encrypted database type for application-level
encryption. Before using this plugin you may want to weigh your options
between [full-disk, database-level, and application-level encryption](https://www.percona.com/blog/2016/04/08/mysql-data-at-rest-encryption/).
This plugin was born out of Amazon Aurora not supporting encryption with cross
region replication before [March 28, 2017](https://aws.amazon.com/blogs/aws/amazon-aurora-update-more-cross-region-cross-account-support-t2-small-db-instances-another-region/).

## Install

Via Composer

``` bash
$ composer require bcrowe/cakephp-encrypted-type
```

Load the plugin in your application's `bootstrap.php` file, then define the type
mapping:

``` php
Plugin::load('BryanCrowe/EncryptedType');
Type::map('encrypted', 'BryanCrowe\EncryptedType\Database\Type\EncryptedType');
```

Make sure to have a `Encryption.key` config value in your `config/app.php` file:

``` php
[
    'Encryption' => [
        'key' => env('ENCRYPTION_KEY', 'defaultencryptionkeygoesrighthereyaythisisfun'),
    ],
]
```

## Usage

**Note:** This database type expects columns to be nullable in the case of an
omitted column or whenever explicitly setting a `null` value for a column.

Use `BLOB` types for columns that are to be encrypted, for example:

``` sql
CREATE TABLE `users` (
  `id` char(36) NOT NULL DEFAULT '',
  `first_name` blob,
  `last_name` blob,
  `email` blob,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

[Map the type](https://book.cakephp.org/3.0/en/orm/database-basics.html#data-types)
to a column in your Table class:

``` php
<?php
namespace App\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\ORM\Table;

class UsersTable extends Table
{

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('name', 'encrypted');
        return $schema;
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed
recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for
details.

## Security

If you discover any security related issues, please email bryan@bryan-crowe.com
instead of using the issue tracker.

## Credits

- [Bryan Crowe][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.

[ico-version]: https://img.shields.io/packagist/v/bcrowe/cakephp-encrypted-type.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bcrowe/cakephp-encrypted-type/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bcrowe/cakephp-encrypted-type.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bcrowe/cakephp-encrypted-type.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bcrowe/cakephp-encrypted-type.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bcrowe/cakephp-encrypted-type
[link-travis]: https://travis-ci.org/bcrowe/cakephp-encrypted-type
[link-scrutinizer]: https://scrutinizer-ci.com/g/bcrowe/cakephp-encrypted-type/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bcrowe/cakephp-encrypted-type
[link-downloads]: https://packagist.org/packages/bcrowe/cakephp-encrypted-type
[link-author]: https://github.com/bcrowe
[link-contributors]: ../../contributors
