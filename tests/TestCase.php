<?php
namespace Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    // This will migrate and rollback the database for each test, or use transactions with a db, automatically migrating
    use DatabaseSetup;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost:12345';

    protected function setUp()
    {
        parent::setUp();
        $this->setupDatabase();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }
}
