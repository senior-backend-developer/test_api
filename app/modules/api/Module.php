<?php

namespace app\modules\api;

use yii\base\Event;
use yii\web\Response;

/**
 * Class Module
 * @package app\modules\api
 */
class Module extends \yii\base\Module
{
    /**
     * @return void
     */
    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        \Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function (Event $event) {
            /** @var Response $response */
            $response = $event->sender;
            $response->data = [
                'success' => ($response->data !== null && $response->statusCode === 200),
                'data' => $response->data,
            ];
        });

        \Yii::$app->user->enableAutoLogin = false;
        \Yii::$app->user->enableSession = false;

        parent::init();
    }
}
