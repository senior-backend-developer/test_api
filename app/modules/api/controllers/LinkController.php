<?php

namespace app\modules\api\controllers;

use app\dto\UrlNotFoundResponseDTO;
use app\models\Link;
use app\models\User;
use Codeception\Util\HttpCode;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class LinkController extends \yii\rest\Controller
{
    public const INDEX_PATH = "api/link/index";

    public function accessRules()
    {
        return [
            [
                'actions' => ['all', 'index'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

    public function verbs()
    {
        return [
            'all' => ['GET'],
            'index' => ['GET', 'POST', 'PATCH', 'DELETE'],
        ];
    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'authenticator' => [
                'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            ],
        ];
    }

    public function actionAll()
    {
        $user = User::findIdentity(Yii::$app->user->id);
        return ['links' => $user->allLinks()];
    }

    public function actionIndex()
    {
        try {
            $user_id = Yii::$app->user->id;
            $request = Yii::$app->request;
            $link_id = $request->get('id') ?? null;
            $absolute_url = $request->absoluteUrl;
            $url_without_get = Yii::$app->getRequest()->getHostInfo().DIRECTORY_SEPARATOR.self::INDEX_PATH;

            if (($request->isGet || $request->isPatch || $request->isDelete)
                && Yii::$app->links->isUrlExist($user_id, $link_id, $absolute_url) === false) {
                return $this->notFoundResponse();
            }

            if ($request->isGet) {
                return Link::findOne($link_id);
            }

            if ($request->isPost) {
                return Yii::$app->links->create($user_id, $url_without_get);
            }

            if ($request->isPatch) {
                return Yii::$app->links->patch($user_id, $link_id, $url_without_get);
            }
            if ($request->isDelete) {
                Yii::$app->links->delete($link_id);
                return "url deleted: $absolute_url";
            }
            return $this->notFoundResponse();
        } catch (\Exception|\Throwable $exception) {
            Yii::$app->response->setStatusCode(HttpCode::CONFLICT);
            return ['error' => $exception->getMessage()]; // Тут конечно, нужен нормальный обработчик ошибок и логирование
        }
    }

    private function notFoundResponse(): UrlNotFoundResponseDTO
    {
        Yii::$app->response->setStatusCode(HttpCode::NOT_FOUND);
        return new UrlNotFoundResponseDTO();
    }
}