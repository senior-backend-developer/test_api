<?php
require 'common.php';

return (new ConfigGenerator([
    'modules' => [ 'api' => [
        'class' => \app\modules\api\Module::class,
        'modules' => [
        ]
    ],],
    'layout' => '@app/views/layouts/main.php',
    'components' => [
        'errorHandler' => [
            //'class' => 'app\components\ErrorHandlerWeb',
        ],
        'user' => null,
        'request' => null,
        'response' => null,
        'assetManager' => null,
        'authClientCollection' => null,
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
    ],

    'container' => null,
]))->getFullConfig();