<?php
/*
 * Copyright (c) 2014 Alberto González
 * Distributed under MIT License
 * (see README for details)
 */

// Core Path
define('MODEL_PATH', GLOBAL_PATH . '/Quaver/App/Model');
define('CONTROLLER_PATH', GLOBAL_PATH . '/Quaver/App/Controller');
define('VENDOR_PATH', GLOBAL_PATH . '/vendor');

// Resource Path
define('FILES_PATH', 'files');
define('THEME_QUAVER', 'Default');
define('BRAND_NAME', 'enjoyZaragoza');

// Cookies
define('COOKIE_NAME', 'enjoyZaragoza');
define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
define('COOKIE_PATH', '/');

// Modes
define('HTTP_MODE', 'http://');
define('MAINTENANCE_MODE', false);
define('DEV_MODE', true);

// Random variable to front files
define('RANDOM_VAR', 'YYYYMMDD'); // format YYYYMMDD

// Template cache, manual clean (Twig)
define('TEMPLATE_CACHE', false);

// Auto reload cache (Twig)
define('CACHE_AUTO_RELOAD', true);

// Default Language
define('LANG', 1);
define('LANG_FORCE', false);

// Database configuration
define('DB_HOSTNAME',  'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'enjoyZaragoza');
define('DB_PORT', '3306');

/*
 * External
 */

// Enabled mailing model
define('MAIL_ENABLED', true);

// Contact mail
define('CONTACT_EMAIL', 'info@mydomain.com');
define('CONTACT_NAME', 'enjoyZaragoza');

// MANDRILL
define('MANDRILL', false);
define('MANDRILL_USERNAME', '');
define('MANDRILL_APIKEY', '');

// Cypher KEY
define('CIPHER_KEY', 'QwErAsDf'); // 8 digits
