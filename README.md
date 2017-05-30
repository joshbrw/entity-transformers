# Entity Transformation Flags

This project provides a base class for standardised Entity Transformers, which can be used to morph entities/objects into arrays. The primary use for these transformers is API Responses.


## Example

```php
<?php

use Joshbrw\EntityTransfomers\EntityTransformer;

class UserTransformer extends EntityTransformer
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
            'title' => $entity->title,
            'first_name' => $entity->first_name,
            'last_name' => $entity->last_name,
            'email' => $entity->email,
            'permissions' => $entity->permissions,
            'age' => $this->getTransformationFlag('showAge') === true ? $entity->age : null
        ];
    }
}
```


Which can then be used to either transform a single entity:

```php
$transformer = new UserTransformer;
$response = $transformer->transform($user);
```

or to transform an Illuminate Collection of entities.

```php
$users = new \Illuminate\Support\Collection($data);
$transformer = new UserTransformer;
$response = $transformer->transform($users);
```

You can also use Transformation Flags to set conditions at runtime, such as:

```php
$transformer = new UserTransformer;
$transformer->setTransformationFlag('showAge', true);
$response = $transformer->transform($user);
```

