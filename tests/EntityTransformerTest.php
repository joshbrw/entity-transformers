<?php

namespace Joshbrw\EntityTransformers\Tests;

use Joshbrw\EntityTransformers\Tests\Stubs\UserEntityTransformer;
use PHPUnit\Framework\TestCase;

class EntityTransformerTest extends TestCase
{

    /** @test */
    public function can_transform_single_user()
    {
        $user = new class {
            public $id = 1;
            public $name = "John Doe";
            public $age = 22;
        };

        $transformer = new UserEntityTransformer;

        $expected = [
            'id' => 1,
            'name' => 'John Doe',
            'age' => 22
        ];

        $response = $transformer->transform($user);

        $this->assertSame($expected, $response);
    }

    /** @test */
    public function can_transform_many()
    {
        $users = [
            new class {
                public $id = 1;
                public $name = "John Doe";
                public $age = 22;
            },
            new class {
                public $id = 2;
                public $name = "Jane Doe";
                public $age = 255;
            },
            new class {
                public $id = 3;
                public $name = "Steve Doe";
                public $age = 16;
            }
        ];

        $transformer = new UserEntityTransformer;

        $expected = [
            [
                'id' => 1,
                'name' => "John Doe",
                'age' => 22,
            ],
            [
                'id' => 2,
                'name' => "Jane Doe",
                'age' => 255,
            ],
            [
                'id' => 3,
                'name' => "Steve Doe",
                'age' => 16,
            ]
        ];

        $response = $transformer->transformMany($users);

        $this->assertSame($expected, $response);
    }

    /** @test */
    public function transformation_flag_defaults_to_null_if_not_set()
    {
        $transformer = new UserEntityTransformer;

        $this->assertFalse($transformer->hasTransformationFlag('showPassword'));
        $this->assertSame(null, $transformer->getTransformationFlag('showPassword'));
    }

    /** @test */
    public function can_set_single_transformation_flag()
    {
        $transformer = new UserEntityTransformer;

        $transformer->setTransformationFlag('showPassword', true);

        $this->assertTrue($transformer->hasTransformationFlag('showPassword'));
        $this->assertSame(true, $transformer->getTransformationFlag('showPassword'));
    }

    /** @test */
    public function can_set_multiple_transformation_flags()
    {
        $transformer = new UserEntityTransformer;

        $flags = [
            'showPassword' => true,
            'hideAge' => true,
            'numberOfEyeballs' => 6
        ];

        $transformer->setTransformationFlags($flags);

        foreach ($flags as $flagName => $flagValue) {
            $this->assertTrue($transformer->hasTransformationFlag($flagName));
            $this->assertSame($flagValue, $transformer->getTransformationFlag($flagName));
        }
    }
}
