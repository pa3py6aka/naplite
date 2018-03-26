<?php

use yii\db\Migration;

/**
 * Handles the creation of table `photo_reports`.
 */
class m180129_100756_create_photo_reports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%photo_reports}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'file' => $this->string()->null()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-photo_reports-recipe_id', '{{%photo_reports}}', 'recipe_id');
        $this->addForeignKey('fk-photo_reports-recipe_id', '{{%photo_reports}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx-photo_reports-user_id', '{{%photo_reports}}', 'user_id');
        $this->addForeignKey('fk-photo_reports-user_id', '{{%photo_reports}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%photo_reports}}');
    }
}
