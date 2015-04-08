# README

[![Build Status](https://secure.travis-ci.org/egeloen/ivory-http-adapter.png?branch=master)](http://travis-ci.org/egeloen/ivory-http-adapter)
[![Coverage Status](https://coveralls.io/repos/egeloen/ivory-http-adapter/badge.png?branch=master)](https://coveralls.io/r/egeloen/ivory-http-adapter?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/egeloen/ivory-http-adapter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/egeloen/ivory-http-adapter/?branch=master)
[![Dependency Status](http://www.versioneye.com/php/egeloen:http-adapter/badge.svg)](http://www.versioneye.com/php/egeloen:http-adapter)

[![Latest Stable Version](https://poser.pugx.org/egeloen/http-adapter/v/stable.svg)](https://packagist.org/packages/egeloen/http-adapter)
[![Latest Unstable Version](https://poser.pugx.org/egeloen/http-adapter/v/unstable.svg)](https://packagist.org/packages/egeloen/http-adapter)
[![Total Downloads](https://poser.pugx.org/egeloen/http-adapter/downloads.svg)](https://packagist.org/packages/egeloen/http-adapter)
[![License](https://poser.pugx.org/egeloen/http-adapter/license.svg)](https://packagist.org/packages/egeloen/http-adapter)

The library allows to issue HTTP requests with PHP 5.3+. The supported adapters are:

 - [cURL](http://curl.haxx.se/)
 - [Fopen](http://php.net/manual/en/function.fopen.php)
 - [FileGetContents](http://php.net/manual/en/function.file-get-contents.php)
 - [Socket](http://php.net/manual/en/function.stream-socket-client.php)
 - [Buzz](https://github.com/kriswallsmith/Buzz)
 - [Guzzle](http://guzzle3.readthedocs.org/)
 - [GuzzleHttp](http://guzzle.readthedocs.org/)
 - [Httpful](http://phphttpclient.com/)
 - [Zend1](http://framework.zend.com/manual/1.12/en/zend.http.html)
 - [Zend2](http://framework.zend.com/manual/2.0/en/modules/zend.http.html)

Additionally, it follows the [PSR-7 Standard](https://github.com/php-fig/fig-standards/blob/master/proposed/http-message.md)
which defines how http message should be implemented.

## Documentation

 1. [Installation](/doc/installation.md)
 2. [Adapters](/doc/adapters.md)
 3. [Configuration](/doc/configuration.md)
 4. [Usage](/doc/usage.md)
 5. [Request](/doc/request.md)
 6. [Internal request](/doc/internal_request.md)
 7. [Response](/doc/response.md)
 8. [Stream](/doc/stream.md)
 9. [Events](/doc/events.md)

## Cookbook

 - [Log requests, responses and exceptions](/doc/events.md#logger)
 - [Journalize requests and responses](/doc/events.md#history)
 - [Throw exceptions for errored responses](/doc/events.md#status-code)
 - [Retry errored requests](/doc/events.md#retry)
 - [Follow redirects](/doc/events.md#redirect)
 - [Manage cookies](/doc/events.md#cookie)

## Testing

The library is fully unit tested by [PHPUnit](http://www.phpunit.de/) with a code coverage close to **100%**. To
execute the test suite, check the travis [configuration](/.travis.yml).

## Contribute

We love contributors! The library is open source, if you'd like to contribute, feel free to propose a PR!

## License

The Ivory Http Adapter is under the MIT license. For the full copyright and license information, please read the
[LICENSE](/LICENSE) file that was distributed with this source code.
