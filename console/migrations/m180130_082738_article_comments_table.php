<?php

use yii\db\Migration;

/**
 * Class m180130_082738_article_comments_table
 */
class m180130_082738_article_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%article_comments}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'reply_to' => $this->integer(),
            'content' => $this->text()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('iacai', '{{%article_comments}}', 'article_id');
        $this->addForeignKey('facai', '{{%article_comments}}', 'article_id', '{{%articles}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('facaiui', '{{%article_comments}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('facrt', '{{%article_comments}}', 'reply_to', '{{%users}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_comments}}');
    }
}
