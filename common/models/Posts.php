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
 * @property string $title
 * @property string $body
 * @property integer $created_at
 */

class Posts extends ActiveRecord
{
    public function fields()
    {
        return ['id',
            'title',
            'body',
            'created_at'=>function(){return date("d.m.Y H:i:s", $this->created_at);},
            'authorName'=>function(){return $this->getAuthors()->one()->username;},
            'iconPath'=>function(){return $this->getAuthors()->one()->iconPath;},
            'comments_count'=>function(){return $this->getComments()->count();},
            'likes_count'=>function(){return $this->getPostLikes()->sum('rating')??0;},
            'comments_count_text'=>function(){$comments_count = $this->getComments()->count(); return $comments_count." ".self::getCommentSuffix($comments_count);},
        ];
    }

    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            ['created_at', 'default', 'value' => function(){return time();}],
            ['author_id', 'default', 'value' => function(){return Yii::$app->user->id;}],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->title = self::purifier($this->title);
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

    public function getPostLikes()
    {
        return $this->hasMany(PostsLikes::class, ['post_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id'])->inverseOf('posts');
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id']);
    }

    public static function bbCodeDecode($curText){
        $curText = preg_replace("/(\[b\])(.+?)(\[\/b\])/i","<span style='font-weight: bold;'>$2</span>",$curText);
        $curText = preg_replace("/(\[i\])(.+?)(\[\/i\])/i","<span style='font-style: italic;'>$2</span>",$curText);
        $curText = preg_replace("/(\[u\])(.+?)(\[\/u\])/i","<span style='text-decoration: underline;'>$2</span>",$curText);
        $curText = preg_replace("/(\[s\])(.+?)(\[\/s\])/i","<span style='text-decoration: line-through;'>$2</span>",$curText);
        $curText = preg_replace("/(\[quote\])(.+?)(\[\/quote\])/i","<blockquote>$2</blockquote>",$curText);
        $curText = preg_replace("/(\[img\])(.+?)(\[\/img\])/i","<img src='$2'>",$curText);
        $curText = preg_replace("/(\[url\])(.+?)(\[\/url\])/i","<a href='$2'>$2</a>",$curText);
        $curText = preg_replace("/(\[url=(.+?)\])(.+?)(\[\/url\])/i","<a href='$2'>$3</a>",$curText);
        $curText = preg_replace("/(\[color='(.+?)'\])(.+?)(\[\/color\])/i","<span style='color: $2;'>$3</span>",$curText);
        /*$curText = preg_replace("/\r\n/i","<br>",$curText);*/

        return $curText;
    }

    public static function getCommentSuffix($commentNum) {
        switch ($commentNum%10){
            case 1:
                switch ($commentNum){
                    case 11: return "комментариев";
                    default: return "комментарий";
                }
            case 2:
            case 3:
            case 4:
                switch ($commentNum){
                    case 12:
                    case 13:
                    case 14: return "комментариев";
                    default: return "комментария";
                }
            default: return "комментариев";
        }
    }
}
