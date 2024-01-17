<?php

namespace app\components\Token;


class JwtValidationData extends \sizeg\jwt\JwtValidationData
{
    public function init()
    {

        $this->validationData->setIssuer(\Yii::$app->params['app_url']);
        $this->validationData->setId(\Yii::$app->user->id);

        parent::init();
    }
}