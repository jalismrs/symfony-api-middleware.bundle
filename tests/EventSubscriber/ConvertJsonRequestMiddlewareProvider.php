<?php
declare(strict_types = 1);

namespace Tests\EventSubscriber;

use function json_encode;
use const JSON_THROW_ON_ERROR;

/**
 * Class ConvertJsonRequestMiddlewareProvider
 *
 * @package Tests\EventSubscriber
 */
final class ConvertJsonRequestMiddlewareProvider
{
    /**
     * provideOnKernelRequest
     *
     * @return array|array[]
     *
     * @throws \JsonException
     */
    public function provideOnKernelRequest() : array
    {
        $parameters = [
            'name' => 'value',
        ];
        
        return [
            'no content'      => [
                'input'  => [
                    'content' => null,
                    'request' => [],
                ],
                'output' => [],
            ],
            'empty content'   => [
                'input'  => [
                    'content' => '',
                    'request' => [],
                ],
                'output' => [],
            ],
            'has parameters'  => [
                'input'  => [
                    'content' => 'test',
                    'request' => $parameters,
                ],
                'output' => $parameters,
            ],
            'invalid content' => [
                'input'  => [
                    'content' => 'test',
                    'request' => [],
                ],
                'output' => [],
            ],
            'valid content'   => [
                'input'  => [
                    'content' => json_encode(
                        $parameters,
                        JSON_THROW_ON_ERROR
                    ),
                    'request' => [],
                ],
                'output' => $parameters,
            ],
        ];
    }
}
