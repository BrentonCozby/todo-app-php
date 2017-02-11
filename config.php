<?php

require __DIR__ . "/vendor/autoload.php";

use Jenssegers\Blade\Blade;

// Enable environment variables with the .env file
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// use templating engine to render html
$blade = new Blade('views', 'cache');

// connect to database
$db = new PDO("mysql:host=" . getenv('HOST') . ";dbname=todoapp", getenv('DBUSER'), getenv('DBPASS'));
