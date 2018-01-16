<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%experiences}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull()->unique(),
            'rate' => $this->integer()->notNull()->defaultValue(0),
            'recipes' => $this->integer()->notNull()->defaultValue(0),
            'system' => $this->boolean()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string(50)->notNull()->defaultValue(''),
            'country' => $this->string(60)->notNull()->defaultValue(''),
            'city' => $this->string(60)->notNull()->defaultValue(''),
            'experience_id' => $this->integer()->notNull(),
            'recipes' => $this->integer()->notNull()->defaultValue(0),
            'about' => $this->text(),
            'avatar' => $this->string(50)->defaultValue(''),
            'rate' => $this->integer()->unsigned()->notNull()->defaultValue(0),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-users-experience_id', '{{%users}}', 'experience_id');
        $this->addForeignKey('fk-users-experience_id-experiences-id', '{{%users}}', 'experience_id', '{{%experiences}}', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%experiences}}');
    }
}
