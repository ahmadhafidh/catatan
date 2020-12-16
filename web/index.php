<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// PHP PATH LOCAL
defined('PHP_PATH') or define('PHP_PATH', 'D:\xampp\php\php.exe');

// PHP PATH SERVER
// defined('PHP_PATH') or define('PHP_PATH', '/usr/bin/php');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
