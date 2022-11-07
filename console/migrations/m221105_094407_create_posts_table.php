<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m221105_094407_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'author_id' => 'INTEGER NOT NULL REFERENCES user(id) ON DELETE CASCADE',
            'title' => $this->string(),
            'body' => $this->text(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-posts-author_id',
            'posts',
            'author_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts}}');
    }
}
