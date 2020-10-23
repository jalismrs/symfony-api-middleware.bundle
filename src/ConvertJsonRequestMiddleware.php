<?php
declare(strict_types = 1);

namespace App\Middleware;

use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function json_decode;

/**
 * Class ConvertJsonRequestMiddleware
 *
 * @package App\Middleware
 */
final class ConvertJsonRequestMiddleware implements
    EventSubscriberInterface
{
    /**
     * logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ConvertJsonRequestMiddleware constructor.
     *
     * @param \Psr\Log\LoggerInterface $middlewareLogger
     */
    public function __construct(
        LoggerInterface $middlewareLogger
    ) {
        $this->logger = $middlewareLogger;
    }

    /**
     * getSubscribedEvents
     *
     * @static
     * @return array|array[]
     *
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest',
                0,
            ],
        ];
    }
    
    /**
     * onKernelRequest
     *
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $requestEvent
     *
     * @return \Symfony\Component\HttpKernel\Event\RequestEvent
     *
     * @throws \LogicException
     */
    public function onKernelRequest(
        RequestEvent $requestEvent
    ) : RequestEvent {
        $request = $requestEvent->getRequest();

        if ($request->request->count() === 0) {
            $content = $request->getContent();

            if (!empty($content)) {
                try {
                    $parameters = json_decode(
                        $content,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    $request->request->replace($parameters);
                } catch (JsonException $jsonException) {
                    $this->logger->error($jsonException);
                }
            }
        }

        return $requestEvent;
    }
}
