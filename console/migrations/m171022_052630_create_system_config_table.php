<?php

use common\models\SystemConfig;

/**
 * Handles the creation of table `system_app`.
 */
class m171022_052630_create_system_config_table extends \console\base\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(SystemConfig::tableName(), [
            'id'        => $this->string(36)->notNull()->unsigned(),
            'key'       => $this->string(255)->notNull()->unique(),
            'value'     => $this->text(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime()
        ], $this->tableOptions);

        $this->addPrimaryKey('systemConfigId', SystemConfig::tableName(), ['id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(SystemConfig::tableName());
    }
}
