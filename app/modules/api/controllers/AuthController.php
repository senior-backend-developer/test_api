<?php

namespace app\modules\api\controllers;

use app\components\Login;
use app\models\User;
use Codeception\Util\HttpCode;
use Yii;

class AuthController extends \yii\rest\Controller
{
    public function accessRules()
    {
        return [
            [
                'actions' => ['register', 'token'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

    public function verbs()
    {
        return [
            'register' => ['POST'],
            'token' => ['POST'],
        ];
    }

    public function actionRegister()
    {
        $user = new User();
        try {
            $post = Yii::$app->getRequest()->getBodyParams();
            $user->username = $post['username'];
            $user->email = $post['email'];
            $user->setPassword($post['password']);
            if ($user->validate() && $user->save()) {
                return ['status' => 'success', 'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                ]];
            }
        } catch (\Exception $exception) {
            return ['status' => 'error', 'data' => $exception->getMessage()];
        }

        return ['status' => 'error', 'data' => $user->getErrors()];
    }

    public function actionToken()
    {
        try {
            $login = new Login();
            $post = Yii::$app->getRequest()->getBodyParams();
            $login->identity = $post['identity'];
            $login->password = $post['password'];
            $token = $login->getToken();
            if ($token) {
                return [
                    'token' => $token,
                    'duration' => Yii::$app->params['token_life_time'],
                ];
            }
        } catch (\Exception $exception) {
            Yii::$app->response->setStatusCode(HttpCode::UNAUTHORIZED);
            return $exception->getMessage();
        }
        Yii::$app->response->setStatusCode(HttpCode::UNAUTHORIZED);
        return $login->getErrors();
    }
}