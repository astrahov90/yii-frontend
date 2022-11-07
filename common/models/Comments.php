<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

/**
 * Posts model
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $post_id
 * @property string $body
 * @property integer $created_at
 */

class Comments extends ActiveRecord
{
    public function fields()
    {
        return ['id',
            'body',
            'post_id',
            'author_id',
            'created_at'=>function(){return date("d.m.Y H:i:s", $this->created_at);},
            'authorName'=>function(){return $this->getAuthors()->one()->username;},
            'iconPath'=>function(){return $this->getAuthors()->one()->iconPath;},
        ];
    }

    public function rules()
    {
        return [
            ['body', 'required'],
            ['created_at', 'default', 'value' => function(){return time();}],
            ['author_id', 'default', 'value' => function(){return Yii::$app->user->id;}],
            ['post_id', 'default', 'value' => function(){return Yii::$app->getRequest()->getQueryParam('post_id');}],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->body = self::purifier($this->body);
            return true;
        } else {
            return false;
        }
    }

    public static function purifier($text)
    {
        $pr = new HtmlPurifier;
        return $pr->process($text);
    }

    public function getAuthors()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id'])->inverseOf('comments');
    }
}
