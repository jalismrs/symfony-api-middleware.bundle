<?php
declare(strict_types = 1);

namespace Jalismrs\ApiMiddlewareBundle;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use function is_array;

/**
 * Class IsApiControllerMiddleware
 *
 * @package Jalismrs\ApiMiddlewareBundle
 */
final class IsApiControllerMiddleware implements
    EventSubscriberInterface
{
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
            KernelEvents::CONTROLLER => [
                'onKernelController',
                0,
            ],
        ];
    }
    
    /**
     * onKernelController
     *
     * @param \Symfony\Component\HttpKernel\Event\ControllerEvent $controllerEvent
     *
     * @return \Symfony\Component\HttpKernel\Event\ControllerEvent
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function onKernelController(
        ControllerEvent $controllerEvent
    ) : ControllerEvent {
        $request    = $controllerEvent->getRequest();
        $controller = self::getController($controllerEvent);
        
        if (
            $controller instanceof IsApiControllerInterface
            &&
            !$request->isXmlHttpRequest()
        ) {
            throw new BadRequestHttpException(
                'You need to set AJAX header'
            );
        }
        
        return $controllerEvent;
    }
    
    private static function getController(
        ControllerEvent $event
    ) : object {
        $controller = $event->getController();
        
        if (is_array($controller)) {
            $controller = $controller[0];
        }
        
        return $controller;
    }
}
