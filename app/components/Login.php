<?php

namespace app\components;

use app\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * @property string $identity
 * @property string $password
 */
class Login extends Model
{
    public $identity;
    public $password;
    private $user = null;

    public function rules()
    {
        return [
            [['identity', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @throws Exception
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                throw new Exception('Login, email or password is incorrect');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function getToken()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if (is_null($user)) {
                return false;
            }
            Yii::$app->user->login($user, Yii::$app->params['token_life_time']);
            return Yii::$app->token->generate($user->id);
        }
        return null;
    }

    /**
     * Finds user by username or email
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = User::findByIdentity($this->identity);
        }
        return $this->user;
    }
}
