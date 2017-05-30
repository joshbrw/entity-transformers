<?php

namespace Joshbrw\EntityTransfomers\Tests\Stubs;

use Joshbrw\EntityTransfomers\EntityTransformer;

class UserEntityTransformer extends EntityTransformer
{

    /**
     * Transform a single Entity into an array
     * @param mixed $entity Entity instance
     * @return array
     */
    public function transform($entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'age' => $entity->age
        ];
    }
}
