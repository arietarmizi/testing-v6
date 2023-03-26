<?php

use console\base\Migration;
use common\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m211108_141234_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(User::tableName(), [
            'id'                 => $this->string(36)->notNull(),
            'fileId'             => $this->string(36),
            'identityCardNumber' => $this->string(100),
            'name'               => $this->string(255)->notNull(),
            'phoneNumber'        => $this->string(36)->notNull()->unique(),
            'email'              => $this->string(100)->notNull()->unique(),
            'birthDate'          => $this->date(),
            'address'            => $this->string(255),
            'type'               => $this->string(50)->defaultValue(User::TYPE_OWNER),
            'verified'           => $this->boolean()->defaultValue(0),
            'verifiedAt'         => $this->dateTime(),
            'passwordHash'       => $this->string(255),
            'passwordResetToken' => $this->string(255),
            'verificationToken'  => $this->string(255),
            'authKey'            => $this->string(255),
            'status'             => $this->string(50)->defaultValue(User::STATUS_ACTIVE),
            'createdAt'          => $this->dateTime(),
            'updatedAt'          => $this->dateTime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('userId', User::tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(User::tableName());
    }
}
