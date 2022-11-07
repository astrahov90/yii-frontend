<?php

namespace common\models;

class Authors extends User
{
    public function fields()
    {
        return ['id',
            'authorName' => 'username',
            'description',
            'created_at'=>function(){return date("d.m.Y H:i:s", $this->created_at);},
            'iconPath',
            'posts_count'=>function(){return $this->getPosts()->count();},
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['author_id' => 'id'])->inverseOf('authors');
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['author_id' => 'id'])->inverseOf('authors');
    }
}