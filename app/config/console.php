<?php
require 'common.php';

return (new ConfigGenerator([
    'controllerNamespace' => 'app\commands',

    'controllerMap' => YII_ENV_DEV ? [
        'fixture' => [ //gen tests fixture controller
            'class'           => 'yii\faker\FixtureController',
            'templatePath'    => '@tests/templates/fixtures',
            'fixtureDataPath' => '@tests/fixtures/data',
        ],
    ] : null,
    'components' => [
        'errorHandler' => [
            //'class' => 'app\components\ErrorHandlerConsole',
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
    ]
]))->getFullConfig();
