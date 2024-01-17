<?php
return [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey'  => '${COOKIE_VALIDATION_KEY}',
    'enableCsrfValidation' => false,
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ]
];