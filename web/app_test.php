<?php
die("ENTRA POR AKI");
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('test', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);


deleteDatabase();
executeCommand($application, "doctrine:schema:create");
executeCommand($application, "doctrine:fixtures:load");

backupDatabase();

function executeCommand($application, $command, Array $options = array()) {
    $options["--env"] = "test";
    $options["--quiet"] = true;
    $options = array_merge($options, array('command' => $command));

    $application->run(new ArrayInput($options));
}

function deleteDatabase() {
    $folder = __DIR__ . '/cache/test/';
    foreach(array('test.db','test.db.bk') AS $file){
        if(file_exists($folder . $file)){
            unlink($folder . $file);
        }
    }
}

function backupDatabase() {
    copy(__DIR__ . '/cache/test/test.db', __DIR__ . '/cache/test/test.db.bk');
}

function restoreDatabase() {
    copy(__DIR__ . '/cache/test/test.db.bk', __DIR__ . '/cache/test/test.db');
}
