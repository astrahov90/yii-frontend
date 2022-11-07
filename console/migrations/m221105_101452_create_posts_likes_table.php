<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_likes}}`.
 */
class m221105_101452_create_posts_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_likes}}', [
            'id' => $this->primaryKey(),
            'author_id' => 'INTEGER NOT NULL REFERENCES user(id) ON DELETE CASCADE',
            'post_id' => 'INTEGER NOT NULL REFERENCES posts(id) ON DELETE CASCADE',
            'rating' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-posts_likes-author_id',
            'posts_likes',
            'author_id'
        );

        $this->createIndex(
            'idx-posts_likes-post_id',
            'posts_likes',
            'post_id'
        );

        $this->createIndex(
            'idx-unique-post_likes-author_id-posts_id',
            'posts_likes',
            ['author_id', 'post_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_likes}}');
    }
}
