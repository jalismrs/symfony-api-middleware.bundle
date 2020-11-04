<?php
declare(strict_types = 1);

namespace Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\EventSubscriber;

use Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\IsApiControllerInterface;
use Jalismrs\Symfony\Common\Helpers\EventHelpers;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class IsApiControllerMiddleware
 *
 * @package Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\EventSubscriber
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
        $controller = EventHelpers::getController($controllerEvent);
        
        if (
            $controller instanceof IsApiControllerInterface
            &&
            !$request->isXmlHttpRequest()
        ) {
            throw new BadRequestHttpException(
                'You need to use an XMLHttpRequest'
            );
        }
        
        return $controllerEvent;
    }
}
