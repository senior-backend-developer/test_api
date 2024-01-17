<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
* @property integer $id
* @property string $url
* @property integer $user_id
* @property integer $creation_datetime
*/
class Link extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%links}}';
    }
}