<?php

use yii\db\Migration;

/**
 * Class m221103_191141_add_user_fields
 */
class m221103_191141_add_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'iconPath', $this->string()->defaultValue(null));
        $this->addColumn('{{%user}}', 'description', $this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221103_191141_add_user_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221103_191141_add_user_fields cannot be reverted.\n";

        return false;
    }
    */
}
