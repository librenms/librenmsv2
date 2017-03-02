<?php

// bootstrap/testing_bootstrap.php

touch(__DIR__.'/../storage/testing.sqlite');
//passthru('>'.__DIR__.'/../storage/testing.sqlite'); // use this if the database may be corrupted
passthru("php artisan --env='testing' migrate");
require __DIR__.'/autoload.php';
