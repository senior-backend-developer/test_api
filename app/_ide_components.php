<?php

use app\components\Links;
use app\components\Token\JwtToken;
use sizeg\jwt\Jwt;


/**
 * @property Jwt $jwt
 * @property JwtToken $token
 * @property Links $links
 */
abstract class BaseApplication extends Application
{
}

class Yii extends BaseYii
{
    /**
     * @var BaseApplication
     */
    public static $app;
}