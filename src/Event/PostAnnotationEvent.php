<?php

namespace KptLucek\ControllerAnnotationReaderBundle\Event;

use Metadata\MethodMetadata;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostAnnotationEvent
 * @package KptLucek\ControllerAnnotationReaderBundle\Event
 */
class PostAnnotationEvent extends Event
{
    const POST_ANNOTATION = 'post.annotation';

    /**
     * @var MethodMetadata
     */
    private $methodMetadata;

    /**
     * @var Request
     */
    private $request;

    /**
     * PostAnnotationEvent constructor.
     *
     * @param MethodMetadata $methodMetadata
     * @param Request        $request
     */
    public function __construct(MethodMetadata $methodMetadata, Request $request)
    {
        $this->methodMetadata = $methodMetadata;
        $this->request        = $request;
    }

    /**
     * @return MethodMetadata
     */
    public function getMethodMetadata(): MethodMetadata
    {
        return $this->methodMetadata;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
