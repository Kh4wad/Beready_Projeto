<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

// phpcs:disable CakePHP.Classes.Import.UseFullyQualifiedName
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\ConnectionHelper;

// phpcs:enable CakePHP.Classes.Import.UseFullyQualifiedName

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

$httpHost = getenv('HTTP_HOST');

// phpcs:disable CakePHP.Usage.YodaConditions
if ((null === $httpHost || '' === $httpHost) && !Configure::read('App.fullBaseUrl')) {
    Configure::write('App.fullBaseUrl', getenv('EMAIL_HOST'));
}
// phpcs:enable CakePHP.Usage.YodaConditions

// DebugKit skips settings these connection config if PHP SAPI is CLI / PHPDBG.
// But since PagesControllerTest is run with debug enabled and DebugKit is loaded
// in application, without setting up these config DebugKit errors out.
ConnectionManager::setConfig('test_debug_kit', [
    'cacheMetadata' => true,
    'className' => 'Cake\Database\Connection',
    'database' => TMP . 'debug_kit.sqlite',
    'driver' => 'Cake\Database\Driver\Sqlite',
    'encoding' => 'utf8',
    'quoteIdentifiers' => false,
]);

ConnectionManager::alias('test_debug_kit', 'debug_kit');

// Fixate now to avoid one-second-leap-issues
Chronos::setTestNow(Chronos::now());

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');

// Connection aliasing needs to happen before migrations are run.
// Otherwise, table objects inside migrations would use the default datasource
ConnectionHelper::addTestAliases();

// (new Migrator())->run();
