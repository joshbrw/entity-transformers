<?php

namespace Joshbrw\EntityTransfomers;

use Illuminate\Support\Collection;

abstract class EntityTransformer
{
    /**
     * @var array
     */
    private $flags = [];

    /**
     * Transform a single Entity into an array
     * @param mixed $entity Entity instance
     * @return array
     */
    abstract public function transform($entity): array;

    /**
     * Transform many instances of an entity
     * @param $items
     * @return array
     */
    public function transformMany($items): array
    {
        if ($items instanceof Collection) {
            $items = $items->all();
        }

        return array_map([$this, 'transform'], $items);
    }

    /**
     * Set a Transformation Flag
     * @param string $flag
     * @param mixed $value
     * @return EntityTransformer
     */
    public function setTransformationFlag(string $flag, $value): EntityTransformer
    {
        $this->flags[$flag] = $value;

        return $this;
    }

    /**
     * Set multiple Transformation Flags
     * @param array $flags Transformation flags, flag => value
     * @return EntityTransformer
     */
    public function setTransformationFlags(array $flags): EntityTransformer
    {
        foreach ($flags as $flag => $value) {
            $this->setTransformationFlag($flag, $value);
        }

        return $this;
    }

    /**
     * Do we have a specific Transformation Flag set?
     * @param string $flag
     * @return bool
     */
    public function hasTransformationFlag(string $flag): bool
    {
        return array_has($this->flags, $flag);
    }

    /**
     * Get a Transformation Flag
     * @param string $flag
     * @param null $default
     * @return mixed
     */
    public function getTransformationFlag(string $flag, $default = null)
    {
        return array_get($this->flags, $flag, $default);
    }

}
