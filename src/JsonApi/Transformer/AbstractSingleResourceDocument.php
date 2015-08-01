<?php
namespace WoohooLabs\Yin\JsonApi\Transformer;

use WoohooLabs\Yin\JsonApi\Request\RelationshipRequest;
use WoohooLabs\Yin\JsonApi\Request\RequestInterface;

abstract class AbstractSingleResourceDocument extends AbstractCompoundDocument
{
    /**
     * @var \WoohooLabs\Yin\JsonApi\Transformer\AbstractResourceTransformer
     */
    protected $transformer;

    /**
     * @param \WoohooLabs\Yin\JsonApi\Transformer\AbstractResourceTransformer $transformer
     */
    public function __construct(AbstractResourceTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param \WoohooLabs\Yin\JsonApi\Request\RequestInterface $request
     */
    protected function setContent(RequestInterface $request)
    {
        $this->data = $this->transformer->transformToResource($this->resource, $request, $this->included);
    }

    /**
     * @param string $relationshipName
     * @param \WoohooLabs\Yin\JsonApi\Request\RequestInterface $request
     * @return array
     */
    protected function getRelationshipContent($relationshipName, RequestInterface $request)
    {
        $request = new RelationshipRequest($request, $this->transformer->getType($this->resource), $relationshipName);

        return $this->transformer->transformRelationship(
            $this->resource,
            $request,
            $this->included,
            $relationshipName
        );
    }
}