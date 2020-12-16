<?php

return [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=catatan',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],
    'log_mongo' => [
        'class' => '\yii\mongodb\Connection',
        'dsn' => 'mongodb://localhost:27017/catatan_db_log',
    ],
];
