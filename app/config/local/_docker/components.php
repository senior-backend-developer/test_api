<?php
return [
    'jwt' => [
        'class' => \sizeg\jwt\Jwt::class,
        'key' => '${JTW_AUTH_SECRET}',
        'jwtValidationData' => \app\components\Token\JwtValidationData::class,
    ],
    'token' => [
        'class' => \app\components\Token\JwtToken::class
    ],
    'links' => [
        'class' => \app\components\Links::class
    ],
];