<?php

use yii\db\Migration;

/**
 * Class m180822_103712_init_rbac
 */
class m180822_103712_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations/', 'db'=> 'db']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_103712_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_103712_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
