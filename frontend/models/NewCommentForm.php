<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Signup form
 */
class NewCommentForm extends Model
{
    public $title;
    public $body;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['body', 'trim'],
            ['body', 'required'],
            ['body', 'string', 'min' => 1, 'max' => 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Новый комментарий',
        ];
    }

    public function formName()
    {
        return '';
    }
}
