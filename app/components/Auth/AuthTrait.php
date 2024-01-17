<?php

namespace app\components\Auth;

use Yii;
use yii\base\Exception;

trait AuthTrait
{
    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword(string $password) : bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * @param int $user_id
     * @param string $key
     * @return void
     */
    public static function saveAuthKey(int $user_id, string $key)
    {
        $user = static::find($user_id)->one();
        $user->auth_key = $key;
        $user->save();
    }
}