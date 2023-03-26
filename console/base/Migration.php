<?php

namespace console\base;

class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();


        echo 'bupind ='. $this->getDb()->driverName;
        // switch based on driver name
        switch ($this->getDb()->driverName) {

            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            default:
                $this->tableOptions = null;
        }
    }

    public function formatForeignKeyName($tableNameForeign, $tableNamePrimary)
    {
        $tableNameForeign = trim($tableNameForeign, '{}');
        $tableNameForeign = str_replace('%', '', $tableNameForeign);
        $tableNamePrimary = trim($tableNamePrimary, '{}');
        $tableNamePrimary = str_replace('%', '', $tableNamePrimary);

        return 'fk_' . $tableNameForeign . '_' . $tableNamePrimary;
    }
}
