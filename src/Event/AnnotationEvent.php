<?php

namespace Lucek\ControllerAnnotationReaderBundle\Event;

use Metadata\MethodMetadata;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MethodAnnotationEvent
 * @package Lucek\FormHandlerBundle\Event
 */
class AnnotationEvent extends Event
{
    const ANNOTATION_METHOD = 'annotation.method';

    /**
     * @var object
     */
    private $annotation;

    /**
     * @var MethodMetadata
     */
    private $methodMetadata;

    /**
     * AnnotationEvent constructor.
     *
     * @param object         $annotation
     * @param MethodMetadata $methodMetadata
     */
    public function __construct($annotation, MethodMetadata $methodMetadata)
    {
        $this->annotation     = $annotation;
        $this->methodMetadata = $methodMetadata;
    }

    /**
     * @return object
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param $annotation
     *
     * @return AnnotationEvent
     */
    public function setAnnotation($annotation): AnnotationEvent
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * @return MethodMetadata
     */
    public function getMethodMetadata(): MethodMetadata
    {
        return $this->methodMetadata;
    }

    /**
     * @param MethodMetadata $methodMetadata
     *
     * @return AnnotationEvent
     */
    public function setMethodMetadata(MethodMetadata $methodMetadata): AnnotationEvent
    {
        $this->methodMetadata = $methodMetadata;

        return $this;
    }
}
