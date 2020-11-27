<?php

// https://github.com/Codeception/Codeception/issues/5411#issuecomment-522275365

// Force test environment
$_ENV['APP_ENV'] = 'test';

// Load the symfony bootstrap file to ensure correct dotenv handling
require dirname(__DIR__).'/config/bootstrap.php';
