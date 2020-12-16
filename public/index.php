<?php
session_start();

// Include conf/confDefine.php file.
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'confDefine.php';

$aModules = array(
    ROOT, APP, VIEW, MODEL, CONTROLLER, DATA, CORE, UPLOAD, LIBRARY, API
);

// Set include paths and use autoloader for class instantiation.
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $aModules));
spl_autoload_register('spl_autoload', false);

// Invoke Application class from the core directory.
$oApplication = new coreApplication();