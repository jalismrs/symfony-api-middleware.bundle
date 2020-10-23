# Symfony Bundle API Middleware

this bundle helps you protect controller actions
with an interface tied to a middleware

this bundle also helps you manage json requests by converting json body to ParameterBag


## Test

`phpunit` or `vendor/bin/phpunit`

coverage reports will be available in `var/coverage`

## Use

```php
use Jalismrs\ApiMiddlewareBundle\IsApiControllerInterface;

class SomeController implements IsApiControllerInterface {

}
```
