# events

[![Latest Stable Version](https://poser.pugx.org/acacha/events/v/stable)](https://packagist.org/packages/acacha/events)
[![Total Downloads](https://poser.pugx.org/acacha/events/downloads)](https://packagist.org/packages/acacha/events)
[![Monthly Downloads](https://poser.pugx.org/acacha/events/d/monthly)](https://packagist.org/packages/acacha/events)
[![Daily Downloads](https://poser.pugx.org/acacha/events/d/daily)](https://packagist.org/packages/acacha/events)
[![composer.lock](https://poser.pugx.org/acacha/events/composerlock)](https://packagist.org/packages/acacha/events)
[![StyleCI](https://styleci.io/repos/107275975/shield?branch=master)](https://styleci.io/repos/107275975)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

# Laravel packages

https://laravel.com/docs/5.5/packages

3 passos instal·lació paquet laravel:

1) Require
2) Install ServiceProvider
3) Install Facades (optional)

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```

## Install

Via Composer

``` bash
$ composer require acacha/events
```

## Usage

``` php
$skeleton = new Acacha\Events();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sergiturbadenas@gmail.com instead of using the issue tracker.

## Credits

- [Sergi Tur Badenas][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/acacha/events.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/acacha/events/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/acacha/events.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/acacha/events.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/acacha/events.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/acacha/events
[link-travis]: https://travis-ci.org/acacha/events
[link-scrutinizer]: https://scrutinizer-ci.com/g/acacha/events/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/acacha/events
[link-downloads]: https://packagist.org/packages/acacha/events
[link-author]: https://github.com/acacha
[link-contributors]: ../../contributors
