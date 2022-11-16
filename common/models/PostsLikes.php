<?php

namespace common\models;

use yii\db\ActiveRecord;


/**
 * Posts model
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $post_id
 * @property integer $rating
 */
class PostsLikes extends ActiveRecord
{
    public function rules()
    {
        return [
            [['author_id', 'post_id', 'rating'], 'required'],
        ];
    }


}
