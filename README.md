Koine Http
-----------------

Work in progress Http models

Code information:

[![Build Status](https://travis-ci.org/koinephp/Http.png?branch=master)](https://travis-ci.org/koinephp/Http)
[![Coverage Status](https://coveralls.io/repos/koinephp/Http/badge.png?branch=master)](https://coveralls.io/r/koinephp/Http?branch=master)
[![Code Climate](https://codeclimate.com/github/koinephp/Http.png)](https://codeclimate.com/github/koinephp/Http)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/koinephp/Http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/koinephp/Http/?branch=master)

Package information:

[![Latest Stable Version](https://poser.pugx.org/koine/http/v/stable.svg)](https://packagist.org/packages/koine/http)
[![Total Downloads](https://poser.pugx.org/koine/http/downloads.svg)](https://packagist.org/packages/koine/http)
[![Latest Unstable Version](https://poser.pugx.org/koine/http/v/unstable.svg)](https://packagist.org/packages/koine/http)
[![License](https://poser.pugx.org/koine/http/license.svg)](https://packagist.org/packages/koine/http)

### Usage

```php

namespace Koine\Http;

$env     = new Environment($_SERVER);
$cookies = new Cookies($_COOKIE);
$session = new Session($_SESSION);
$post    = new Params($_POST);
$get     = new Params($_GET);
$params  = new Params($_REQUEST);

$request = new Request(array(
    'env'     => $env,
    'cookies' => $cookies,
    'session' => $session,
    'post'    => $post,
    'get'     => $get,
    'params'  => $params,
));

$hello = function ($request) {

    $response = new Response(array(
        'cookies' => $cookies,
    ));

    return $response->setBody('Hello Word!');
};

// If page is hello

$hello()->send();

$redirect = function ($request) {

    $response = new Response(array(
          'cookies' => $cookies,
    ));

    return $response->setRedirect('/');
};

// If page is redirect

$redirect()->send();

```

### Installing

#### Via Composer
Append the lib to your requirements key in your composer.json.

```javascript
{
    // composer.json
    // [..]
    require: {
        // append this line to your requirements
        "koine/http": "dev-master"
    }
}
```

### Alternative install
- Learn [composer](https://getcomposer.org). You should not be looking for an alternative install. It is worth the time. Trust me ;-)
- Follow [this set of instructions](#installing-via-composer)

### Issues/Features proposals

[Here](https://github.com/koinephp/http/issues) is the issue tracker.

### Contributing

Only TDD code will be accepted. Please follow the [PSR-2 code standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

### How to run the tests:

```bash
phpunit --configuration tests/phpunit.xml
```

### To check the code standard run:

```bash
phpcs --standard=PSR2 lib
phpcs --standard=PSR2 tests
```

### Lincense
[MIT](MIT-LICENSE)

### Authors

- [Marcelo Jacobus](https://github.com/mjacobus)
