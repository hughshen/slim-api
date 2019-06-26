<?php

// Instantiate the app
$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App(array(
	'settings' => $settings,
));

// Set up dependencies
require __DIR__ . '/dependencies.php';

// Register middlewares
require __DIR__ . '/middlewares.php';

// Register routes
require __DIR__ . '/routes.php';

return $app;
