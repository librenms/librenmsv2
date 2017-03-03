<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseSetup;
    use DatabaseTransactions;

    /**
     * The base URL of the application.
     *
     * @var string
     */
    public $baseUrl = 'http://localhost:43253';

    public function setUp()
    {
        parent::setUp();
        $this->setupDatabase();
    }
}
