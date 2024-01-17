<?php

namespace app\models;

use app\components\Auth\AuthTrait;
use Lcobucci\JWT\Token;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property string $auth_key
 * @property string $password_hash
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Link[] $links
 **/
class User extends ActiveRecord implements IdentityInterface
{
    use AuthTrait;

    public const STATUS_ACTIVE = 1;

    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
        ];
    }

    public static function findIdentity($id)
    {
        return static::find()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * {@inheritdoc}
     * @param Token $token
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (empty($token)) {
            return null;
        }

        $user = \app\models\User::findIdentity($token->getClaim('uid'));
        if ($user->getAuthKey() === (string)$token) {
            return new static($user);
        }
        return null;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * Finds user by username or email
     *
     * @param $identity
     * @return User|ActiveRecord|null
     */
    public static function findByIdentity($identity)
    {
        $query = static::find();
        return $query
            ->andWhere(['or',
                ['username' => $identity],
                ['email' => $identity],
            ])
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @return ActiveQuery
     */
    public function getLinks(): ActiveQuery
    {
        return $this->hasMany(Link::class, ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public function allLinks(): array
    {
        $data = Link::find()
            ->andWhere(['user_id' => $this->id])
            ->andWhere(['IS NOT', 'url', null])
            ->select(['id', 'url'])
            ->asArray()->all();

        return ArrayHelper::map($data, 'id', 'url');
    }
}