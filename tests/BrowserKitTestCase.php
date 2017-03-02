<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseSetup;
    use DatabaseMigrations;

    /**
     * The base URL of the application.
     *
     * @var string
     */
    public $baseUrl = 'http://localhost:43253';

    public function setUp()
    {
        $this->initSqliteFile();
        parent::setUp();
        $this->setupDatabase();
    }
}
