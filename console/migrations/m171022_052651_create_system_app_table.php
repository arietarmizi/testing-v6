<?php

use common\models\SystemApp;

/**
 * Handles the creation of table `system_app`.
 */
class m171022_052651_create_system_app_table extends \console\base\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(SystemApp::tableName(), [
            'id'        => $this->string(36)->notNull()->unsigned(),
            'name'      => $this->string(255)->notNull(),
            'appKey'    => $this->string(255)->notNull()->unique(),
            'appSecret' => $this->string(255)->notNull(),
            'type'      => $this->string(50)->notNull(),
            'ip'        => $this->string(255),
            'status'    => $this->string(50)->notNull(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime()
        ], $this->tableOptions);

        $this->addPrimaryKey('systemAppId', SystemApp::tableName(), ['id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(SystemApp::tableName());
    }
}
