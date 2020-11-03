# symfony.bundle.api-middleware

Adds a protected controller interface and its middleware along with a JSON middleware converter

## Test

`phpunit` or `vendor/bin/phpunit`

coverage reports will be available in `var/coverage`

## Use

```php
use Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\IsApiControllerInterface;

class SomeController implements IsApiControllerInterface {

}
```
