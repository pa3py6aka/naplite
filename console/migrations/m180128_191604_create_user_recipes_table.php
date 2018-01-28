<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_recipes`.
 */
class m180128_191604_create_user_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%user_recipes}}', [
            'user_id' => $this->integer()->notNull(),
            'recipe_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('pk-user_recipes', '{{%user_recipes}}', ['user_id', 'recipe_id']);
        $this->createIndex('idx-user_recipes-user_id', '{{%user_recipes}}', 'user_id');
        $this->createIndex('idx-user_recipes-recipe_id', '{{%user_recipes}}', 'recipe_id');
        $this->addForeignKey('fk-user_recipes-user_id', '{{%user_recipes}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_recipes-recipe_id', '{{%user_recipes}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%user_recipes}}');
    }
}
