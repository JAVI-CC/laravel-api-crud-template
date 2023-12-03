<?php

namespace Tests;

use Database\Seeders\RolSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->seed(RolSeeder::class);
    }
}
