# UPGRADE

### 0.4 to 0.5

 * The `Ivory\HttpAdapter\Guzzle3HttpAdapter` has been renamed to `Ivory\HttpAdapter\GuzzleHttpAdapter` and its name
   has been renamed to from `guzzle3` to `guzzle` as well.

 * The `Ivory\HttpAdapter\Guzzle4HttpAdapter` has been renamed to `Ivory\HttpAdapter\GuzzleHttpHttpAdapter`, its
   name has been renamed to from `guzzle4` to `guzzle_http` and it now supports Guzzle 5.

 * The `Ivory\HttpAdapter\Message\Stream\Guzzle3Stream` has been renamed to
   `Ivory\HttpAdapter\Message\Stream\GuzzleStream`.

 * The `Ivory\HttpAdapter\Message\Stream\Guzzle4Stream` has been renamed to
   `Ivory\HttpAdapter\Message\Stream\GuzzleHttpStream` and it now supports Guzzle 5.

### 0.3 to 0.4

 * The PSR HTTP message dependency has break the backward compatibility.
   See https://github.com/php-fig/http-message/compare/0.3.0...0.4.0

### 0.2 to 0.3

 * The PSR HTTP message dependency has break the backward compatibility.
   See https://github.com/php-fig/http-message/compare/0.2.0...0.3.0

### 0.1 to 0.2

 * The PSR HTTP message dependency has break the backward compatibility.
   See https://github.com/php-fig/http-message/compare/0.1.0...0.2.0

 * The `Ivory\HttpAdapter\Message\Stream\AbstractStream` has two new abstract methods (`doAttach` and `doGetMetadata`)
   which have been added in order to reflect the PSR HTTP message changes.

 * The `Ivory\HttpAdapter\HttpAdapterException::resourceIsNotValid` has been renamed to `streamIsNotValid` and it now
   takes the stream as first parameter, the wrapper as second parameter and the expected stream as third parameter.

 * The `Ivory\HttpAdapter\Message\Stream\ResourceSteam::$isReadable`,
   `Ivory\HttpAdapter\Message\Stream\ResourceSteam::$isWritable`,
   `Ivory\HttpAdapter\Message\Stream\ResourceSteam::$isSeekable` and
   `Ivory\HttpAdapter\Message\Stream\ResourceSteam::$isLocal` properties have been removed as it does not bring any
   values and are only used internally.

 * The `Ivory\HttpAdapter\Message\Stream\ResourceSteam::$modes` structure has been simplified.

 * The `Ivory\HttpAdapter\Message\Stream\ResourceSteam::isLocal`,
   `Ivory\HttpAdapter\Message\Stream\ResourceSteam::buildCache` and
   `Ivory\HttpAdapter\Message\Stream\ResourceSteam::clearCache` methods have been removed.
