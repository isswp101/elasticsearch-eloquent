<?php

namespace Isswp101\Persimmon\Relationship;

use Isswp101\Persimmon\ElasticsearchModel;
use Isswp101\Persimmon\QueryBuilder\Filters\ParentFilter;
use Isswp101\Persimmon\QueryBuilder\QueryBuilder;

class HasManyRelationship
{
    /**
     * @var ElasticsearchModel
     */
    protected $parent;

    /**
     * @var ElasticsearchModel
     */
    protected $childClassName;

    function __construct(ElasticsearchModel $parent, $childClassName)
    {
        $this->parent = $parent;
        $this->childClassName = $childClassName;
    }

    /**
     * Find all children.
     *
     * @return ElasticsearchModel[]
     */
    public function get()
    {
        $child = $this->childClassName;
        $query = new QueryBuilder();
        $query->filter(new ParentFilter($this->parent->getId()));
        return $child::search($query);
    }

    /**
     * Find document by id.
     *
     * @param mixed $id
     * @return ElasticsearchModel
     */
    public function find($id)
    {
        $child = $this->childClassName;
        $model = $child::findWithParentId($id, $this->parent->getId());
        if ($model) {
            $model->setParent($this->parent);
        }
        return $model;
    }

    /**
     * Save children.
     *
     * @param ElasticsearchModel|ElasticsearchModel[] $child
     */
    public function save($child)
    {
        /** @var ElasticsearchModel[] $children */
        $children = !is_array($child) ? [$child] : $child;
        // @TODO: use bulk if count($children) > 1
        foreach ($children as $child) {
            $child->setParent($this->parent);
            $child->save();
        }
    }
}