<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseSetup;

    public function setUp()
    {
        parent::setUp();
        $this->setupDatabase();
    }
}
