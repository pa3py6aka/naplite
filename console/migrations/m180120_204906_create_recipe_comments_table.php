<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recipe_comments`.
 */
class m180120_204906_create_recipe_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%recipe_comments}}', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'reply_to' => $this->integer(),
            'content' => $this->text()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-recipe_comments-recipe_id', '{{%recipe_comments}}', 'recipe_id');
        $this->addForeignKey('fk-recipe_comments-recipe_id', '{{%recipe_comments}}', 'recipe_id', '{{%recipes}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-recipe_comments-author_id', '{{%recipe_comments}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-recipe_comments-reply_to', '{{%recipe_comments}}', 'reply_to', '{{%users}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%recipe_comments}}');
    }
}
