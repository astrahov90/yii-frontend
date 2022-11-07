<?php

namespace frontend\models;

use yii\base\Model;

class NewPostForm extends Model
{
    public $title;
    public $body;

    public function rules()
    {
        return [
            ['body', 'trim'],
            ['body', 'required'],
            ['body', 'string', 'min' => 1, 'max' => 1024],


            ['title', 'trim'],
            ['title', 'required'],
            ['title', 'string', 'min' => 1, 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок поста',
            'body' => 'Текст поста',
        ];
    }

    public function formName()
    {
        return '';
    }

}
