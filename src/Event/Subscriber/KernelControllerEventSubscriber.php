<?php

namespace Lucek\ControllerAnnotationReaderBundle\Event\Subscriber;

use Doctrine\Common\Annotations\Reader;
use Metadata\MethodMetadata;
use Lucek\ControllerAnnotationReaderBundle\Event\AnnotationEvent;
use Lucek\ControllerAnnotationReaderBundle\Event\PostAnnotationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class KernelControllerEventSubscriber
 * @package Lucek\ControllerAnnotationReaderBundle\Event\Subscriber
 */
class KernelControllerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * KernelControllerEventSubscriber constructor.
     *
     * @param Reader                   $reader
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Reader $reader, EventDispatcherInterface $eventDispatcher)
    {
        $this->reader          = $reader;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return ['kernel.controller' => 'onKernelController'];
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws \ReflectionException
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        if (false === $event->isMasterRequest()) {
            return;
        }

        $controller = $event->getController();
        $request    = $event->getRequest();

        // Old fashion designed routing by SomeController::someAction
        if (true === is_array($controller)) {
            $metadata = new \ReflectionMethod($controller[0], $controller[1]);
            $this->notifyAnnotations($metadata, $request, $this->reader->getMethodAnnotations($metadata));

            return;
        }

        // New fashion designed routing by SomeController (__invoke)
        if (true === is_callable($controller) && false === is_array($controller)) {
            $metadata = new \ReflectionMethod($controller, '__invoke');
            $this->notifyAnnotations($metadata, $request, $this->reader->getMethodAnnotations($metadata));

            return;
        }
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     * @param Request           $request
     * @param array             $annotations
     */
    private function notifyAnnotations(\ReflectionMethod $reflectionMethod, Request $request, array $annotations): void
    {
        $metadata = new MethodMetadata($reflectionMethod->class, $reflectionMethod->name);

        foreach ($annotations as $annotation) {
            $this->eventDispatcher->dispatch(AnnotationEvent::ANNOTATION_METHOD, new AnnotationEvent($annotation, $metadata));
        }

        $this->eventDispatcher->dispatch(PostAnnotationEvent::POST_ANNOTATION, new PostAnnotationEvent($metadata, $request));
    }
}
