<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m221105_101503_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'author_id' => 'INTEGER NOT NULL REFERENCES user(id) ON DELETE CASCADE',
            'post_id' => 'INTEGER NOT NULL REFERENCES posts(id) ON DELETE CASCADE',
            'body' => $this->text(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-comments-author_id',
            'comments',
            'author_id'
        );

        $this->createIndex(
            'idx-comments-posts_id',
            'comments',
            'post_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }
}
