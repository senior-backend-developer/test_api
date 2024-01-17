<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=${DB_MYSQL_MASTER_HOST};dbname=${DB_MYSQL_MASTER_NAME}',
    'username' => '${DB_MYSQL_MASTER_USER}',
    'password' => '${DB_MYSQL_MASTER_PASSWORD}',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
];