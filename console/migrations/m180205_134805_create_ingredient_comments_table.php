<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredient_comments`.
 */
class m180205_134805_create_ingredient_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%ingredient_comments}}', [
            'id' => $this->primaryKey(),
            'ingredient_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'reply_to' => $this->integer(),
            'content' => $this->text()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('iicii', '{{%ingredient_comments}}', 'ingredient_id');
        $this->addForeignKey('ficii', '{{%ingredient_comments}}', 'ingredient_id', '{{%ingredients}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ficai', '{{%ingredient_comments}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ficrt', '{{%ingredient_comments}}', 'reply_to', '{{%users}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%ingredient_comments}}');
    }
}
