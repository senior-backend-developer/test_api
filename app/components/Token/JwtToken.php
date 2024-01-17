<?php

namespace app\components\Token;

use app\models\User;
use Yii;

class JwtToken implements TokenInterface
{
    /**
     * @param int $user_id
     * @return string|null
     */
    public function generate(int $user_id): ?string
    {
        $token = $this->getToken($user_id);
        User::saveAuthKey($user_id, $token);
        return $token;
    }

    /**
     * @param int $user_id
     * @return string
     */
    protected function getToken(int $user_id): string
    {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        $token = $jwt->getBuilder()
            ->issuedBy(Yii::$app->params['app_url'])
            ->identifiedBy($user_id, true)
            ->issuedAt($time)
            ->expiresAt($time + Yii::$app->params['token_life_time'])
            ->withClaim('uid', $user_id)// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token

        return (string)$token;
    }
}