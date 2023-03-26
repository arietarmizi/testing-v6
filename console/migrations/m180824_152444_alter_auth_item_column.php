<?php

use yii\db\Migration;

/**
 * Class m180824_152444_alter_auth_item_column
 */
class m180824_152444_alter_auth_item_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%auth_item}}', 'data', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180824_152444_alter_auth_item_column cannot be reverted.\n";

        return false;
    }
}
